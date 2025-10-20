<?php

namespace App\Http\Controllers;

use App\Models\{Cita, Servicio, Horario, Bloqueo};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CitaController extends Controller
{
    public function index() {
        $citas = Cita::with('servicios')
            ->where('user_id', auth()->id())
            ->orderByDesc('fecha')->orderByDesc('hora')
            ->paginate(10);

        return view('citas.index', compact('citas'));
    }

    public function create(Request $r) {
        $servicios = Servicio::orderBy('nombre')->get();
        $slots = [];

        if ($r->filled('fecha')) {
            $slots = $this->slotsDisponibles($r->date('fecha'));
        }

        return view('citas.create', compact('servicios', 'slots'));
    }

    public function store(Request $r) {
        $data = $r->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora'  => 'required|date_format:H:i',
            'servicios' => 'required|array|min:1',
            'servicios.*' => 'exists:servicios,id',
        ]);

        $dia = Carbon::parse($data['fecha'])->dayOfWeekIso; // 1..7
        $horario = Horario::where('dia_semana', $dia)->firstOrFail();

        $inicio = Carbon::createFromFormat('H:i', $data['hora']);
        $fin = (clone $inicio)->addMinutes($horario->duracion_min);

        if (!$this->slotDisponible($data['fecha'], $inicio, $fin)) {
            return back()->withErrors(['hora' => 'Ese horario ya está ocupado o bloqueado.'])->withInput();
        }

        $cita = Cita::create([
            'fecha'   => $data['fecha'],
            'hora'    => $inicio->format('H:i'),
            'hora_fin'=> $fin->format('H:i'),
            'user_id' => auth()->id(),
            'estado'  => 'pendiente',
        ]);

        $cita->servicios()->sync($data['servicios']);

        return redirect()->route('citas.index')->with('ok', 'Cita reservada.');
    }

    /** --- Helpers de disponibilidad --- */

   private function slotsDisponibles(Carbon $fecha): array
{
    $dia = $fecha->dayOfWeekIso; // 1..7
    $tramos = Horario::where('dia_semana', $dia)->get();

    if ($tramos->isEmpty()) {
        return []; // día sin atención
    }

    // Helper: combina la fecha con un TIME (acepta H:i o H:i:s)
    $atFecha = function ($time) use ($fecha) {
        if (empty($time)) return null;
        // Concatena la fecha para que Carbon no falle por formato
        return Carbon::parse($fecha->format('Y-m-d') . ' ' . $time);
    };

    // Intervalos no disponibles (citas + bloqueos), normalizados al mismo día
    $ocupados = Cita::whereDate('fecha', $fecha)
        ->whereIn('estado', ['pendiente', 'confirmada'])
        ->get(['hora', 'hora_fin'])
        ->map(function ($c) use ($atFecha) {
            return [$atFecha($c->hora), $atFecha($c->hora_fin)];
        });

    $bloqueos = Bloqueo::whereDate('fecha', $fecha)
        ->get(['hora_inicio', 'hora_fin'])
        ->map(function ($b) use ($atFecha) {
            return [$atFecha($b->hora_inicio), $atFecha($b->hora_fin)];
        });

    $noDisponibles = $ocupados->concat($bloqueos);

    $slots = [];

    foreach ($tramos as $h) {
        // Soporta que abre/cierra vengan como 'H:i' o 'H:i:s'
        $abre   = $atFecha($h->abre);
        $cierra = $atFecha($h->cierra);
        $dur    = (int) $h->duracion_min;

        if (!$abre || !$cierra || $dur <= 0 || $abre->gte($cierra)) {
            // Si hay datos inválidos en el horario, saltamos ese tramo
            continue;
        }

        for ($t = $abre->copy(); $t->lt($cierra); $t->addMinutes($dur)) {
            $fin = $t->copy()->addMinutes($dur);
            if ($fin->gt($cierra)) break;

            // ¿Se solapa con algo no disponible?
            $solapa = $noDisponibles->contains(function ($par) use ($t, $fin) {
                [$s, $e] = $par;
                return $t->lt($e) && $fin->gt($s);
            });

            if (!$solapa) {
                $slots[] = $t->format('H:i'); // para el <option>
            }
        }
    }

    // Quitar duplicados y ordenar
    $slots = array_values(array_unique($slots));
    sort($slots);

    return $slots;
}

    private function slotDisponible($fecha, Carbon $inicio, Carbon $fin): bool {
        $bloqueado = Bloqueo::whereDate('fecha', $fecha)
            ->where(function ($q) use ($inicio, $fin) {
                $q->whereBetween('hora_inicio', [$inicio->format('H:i'), $fin->format('H:i')])
                  ->orWhereBetween('hora_fin', [$inicio->format('H:i'), $fin->format('H:i')])
                  ->orWhere(function ($q2) use ($inicio, $fin) {
                      $q2->where('hora_inicio', '<=', $inicio->format('H:i'))
                         ->where('hora_fin', '>=', $fin->format('H:i'));
                  });
            })->exists();

        if ($bloqueado) return false;

        $ocupado = Cita::whereDate('fecha', $fecha)
            ->whereIn('estado', ['pendiente','confirmada'])
            ->where('hora', '<', $fin->format('H:i'))
            ->where('hora_fin', '>', $inicio->format('H:i'))
            ->exists();

        return !$ocupado;
    }
}
