<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;

class CitaAdminController extends Controller
{
    public function cancel(Request $request, Cita $cita)
    {
        // Opcional: si quieres evitar re-cancelar
        if ($cita->estado === 'cancelada') {
            return back()->with('ok', 'La cita ya estaba cancelada.');
        }

        $cita->estado = 'cancelada';
        $cita->save();

        // Opcional: notificar al usuario por email (si lo tienes montado)
        // Notification::send($cita->usuario, new CitaCanceladaNotification($cita));

        return back()->with('ok', 'Cita cancelada correctamente.');
    }
}
