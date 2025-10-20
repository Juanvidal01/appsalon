<x-app-layout>
  <x-slot name="header">Gestionar servicios</x-slot>

  <x-slot name="actions">
    <div class="flex items-center gap-2">
      {{-- Buscador opcional --}}
      <form method="GET" action="{{ route('admin.servicios.index') }}" class="hidden md:flex items-center gap-2">
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Buscar servicio..."
               class="input w-64">
        <button class="btn-secondary">Buscar</button>
      </form>

      <a href="{{ route('admin.servicios.create') }}" class="btn-primary">Nuevo servicio</a>
    </div>
  </x-slot>

  @if(session('ok'))
    <div class="panel mb-4">
      <div class="card-pad text-green-700 bg-green-50 border border-green-200 rounded">
        {{ session('ok') }}
      </div>
    </div>
  @endif

  <div class="panel">
    <div class="card-pad table-wrap">
      <table class="table">
        <thead class="thead">
          <tr>
            <th class="th">Nombre</th>
            <th class="th">Precio</th>
            <th class="th">Descripción</th>
            <th class="th text-right">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse($servicios as $s)
            <tr class="tr">
              <td class="td font-medium">{{ $s->nombre }}</td>
              <td class="td">$ {{ number_format($s->precio, 0, ',', '.') }}</td>
              <td class="td text-sm text-gray-600">
                @if(!empty($s->descripcion))
                  {{ \Illuminate\Support\Str::limit($s->descripcion, 100) }}
                @else
                  <span class="text-gray-400">—</span>
                @endif
              </td>
              <td class="td text-right">
                <a href="{{ route('admin.servicios.edit', $s) }}" class="btn-secondary">Editar</a>

                <form method="POST" action="{{ route('admin.servicios.destroy', $s) }}"
                      onsubmit="return confirm('¿Eliminar este servicio?');"
                      class="inline">
                  @csrf
                  @method('DELETE')
                  <button class="btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td class="td text-center muted py-6" colspan="4">No hay servicios.</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-4">{{ $servicios->links() }}</div>
    </div>
  </div>
</x-app-layout>
