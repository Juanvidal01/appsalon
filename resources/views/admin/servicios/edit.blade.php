<x-app-layout>
  <x-slot name="header">Editar servicio</x-slot>

  <div class="panel">
    <div class="card-pad">
      @if ($errors->any())
        <div class="mb-4 text-red-700 bg-red-100 border border-red-300 rounded p-3 text-sm">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('admin.servicios.update', $servicio) }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf
        @method('PUT')

        <div>
          <label class="label">Nombre</label>
          <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre) }}" class="input" required>
        </div>

        <div>
          <label class="label">Precio</label>
          <input type="number" name="precio" value="{{ old('precio', $servicio->precio) }}" class="input" min="0" step="0.01" required>
        </div>

        <div class="md:col-span-2">
          <label class="label">Descripción (opcional)</label>
          <textarea name="descripcion" rows="4" class="input">{{ old('descripcion', $servicio->descripcion) }}</textarea>
        </div>

        <div class="md:col-span-2 flex items-center gap-2">
          <button class="btn-primary">Actualizar</button>
          <a href="{{ route('admin.servicios.index') }}" class="btn-secondary">Volver</a>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
