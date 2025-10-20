<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioAdminController extends Controller
{
    public function index(Request $request)
    {
        // Búsqueda opcional (si no usas buscador, igual funciona)
        $q = trim($request->input('q', ''));

        $servicios = Servicio::query()
            ->when($q, fn($w) =>
                $w->where('nombre', 'like', "%{$q}%")
            
            )
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('admin.servicios.index', compact('servicios', 'q'));
    }

    public function create()
    {
        return view('admin.servicios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:100'],
            'precio'      => ['required','numeric','min:0'],
            'descripcion' => ['nullable','string','max:500'],
        ]);

        Servicio::create($data);

        return redirect()
            ->route('admin.servicios.index')
            ->with('ok', 'Servicio creado correctamente.');
    }

    public function edit(Servicio $servicio)
    {
        return view('admin.servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:100'],
            'precio'      => ['required','numeric','min:0'],
            'descripcion' => ['nullable','string','max:500'],
        ]);

        $servicio->update($data);

        return redirect()
            ->route('admin.servicios.index')
            ->with('ok', 'Servicio actualizado correctamente.');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();

        return back()->with('ok', 'Servicio eliminado.');
    }
}
