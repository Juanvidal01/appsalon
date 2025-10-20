<?php

namespace App\Http\Controllers;

use App\Models\Cita;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $proxima = Cita::with('servicios')
            ->where('user_id', $user->id)
            ->whereIn('estado', ['pendiente','confirmada'])
            ->whereDate('fecha', '>=', now()->toDateString())
            ->orderBy('fecha')->orderBy('hora')
            ->first();

        $stats = [
            'total'       => Cita::where('user_id',$user->id)->count(),
            'pendientes'  => Cita::where('user_id',$user->id)->where('estado','pendiente')->count(),
            'confirmadas' => Cita::where('user_id',$user->id)->where('estado','confirmada')->count(),
            'canceladas'  => Cita::where('user_id',$user->id)->where('estado','cancelada')->count(),
        ];

        $ultimas = Cita::with('servicios')
            ->where('user_id',$user->id)
            ->orderByDesc('fecha')->orderByDesc('hora')
            ->take(5)->get();

        // IMPORTANTE: usaremos tu vista existente: resources/views/dashboard.blade.php
        return view('dashboard', compact('user','proxima','stats','ultimas'));
    }
}
