<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioPublicController extends Controller
{
    public function index(Request $request)
    {
        $q     = trim($request->input('q', ''));
        $order = $request->input('order', 'nombre'); // nombre|precio_asc|precio_desc

        $servicios = Servicio::query()
            ->when($q, fn($w) =>
                $w->where('nombre', 'like', "%{$q}%")
                
            )
            ->when($order === 'precio_asc',  fn($w) => $w->orderBy('precio', 'asc'))
            ->when($order === 'precio_desc', fn($w) => $w->orderBy('precio', 'desc'))
            ->when($order === 'nombre',      fn($w) => $w->orderBy('nombre'))
            ->paginate(12)
            ->withQueryString();

        return view('servicios.index', compact('servicios', 'q', 'order'));
    }
}
