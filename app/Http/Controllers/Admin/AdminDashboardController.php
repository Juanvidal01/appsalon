<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Fecha seleccionada (string 'Y-m-d'); default: hoy
        $fecha = $request->input('fecha', now()->toDateString());

        // Citas del día
        $citasDia = Cita::with(['servicios', 'usuario'])
            ->whereDate('fecha', $fecha)
            ->orderBy('hora')
            ->get();

        // Ingresos NETOS del día: excluye canceladas
        $ingresosDia = DB::table('citas')
            ->join('cita_servicio', 'citas.id', '=', 'cita_servicio.cita_id')
            ->join('servicios', 'servicios.id', '=', 'cita_servicio.servicio_id')
            ->whereDate('citas.fecha', $fecha)
            ->where('citas.estado', '!=', 'cancelada') // 👈 excluye canceladas
            ->sum('servicios.precio');

        $stats = [
            'citas_dia'   => $citasDia->count(),
            'ingresos_dia'=> $ingresosDia,
            'pendientes'  => Cita::whereDate('fecha', $fecha)->where('estado', 'pendiente')->count(),
            'confirmadas' => Cita::whereDate('fecha', $fecha)->where('estado', 'confirmada')->count(),
        ];

        // Top servicios últimos 30 días (también excluye canceladas)
        $desde = now()->subDays(30)->toDateString();
        $hasta = now()->toDateString();

        $topServicios = DB::table('cita_servicio')
            ->join('citas', 'citas.id', '=', 'cita_servicio.cita_id')
            ->join('servicios', 'servicios.id', '=', 'cita_servicio.servicio_id')
            ->whereBetween('citas.fecha', [$desde, $hasta])
            ->where('citas.estado', '!=', 'cancelada')
            ->select('servicios.nombre',
                DB::raw('COUNT(*) as usos'),
                DB::raw('SUM(servicios.precio) as ingresos')
            )
            ->groupBy('servicios.nombre')
            ->orderByDesc('usos')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'fecha'        => $fecha,
            'stats'        => $stats,
            'citasDia'     => $citasDia,
            'topServicios' => $topServicios,
            'rangoTop'     => [$desde, $hasta],
        ]);
    }
}
