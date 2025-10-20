<x-app-layout>
  <x-slot name="header">
    Mis Citas
  </x-slot>

  <div class="max-w-5xl mx-auto mt-8 bg-white shadow p-6 rounded-lg">
    @if (session('ok'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('ok') }}
      </div>
    @endif

    <table class="w-full text-sm text-left text-gray-700 border-collapse">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-3 border">Fecha</th>
          <th class="p-3 border">Hora</th>
          <th class="p-3 border">Servicios</th>
          <th class="p-3 border">Estado</th>
          <th class="p-3 border text-right">Total</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($citas as $c)
          <tr class="hover:bg-gray-50">
            <td class="p-3 border">{{ $c->fecha->format('Y-m-d') }}</td>
            <td class="p-3 border">{{ $c->hora->format('H:i') }} - {{ $c->hora_fin->format('H:i') }}</td>
            <td class="p-3 border">{{ $c->servicios->pluck('nombre')->join(', ') }}</td>
            <td class="p-3 border capitalize">
              <span class="@class([
                  'text-yellow-600' => $c->estado === 'pendiente',
                  'text-green-600' => $c->estado === 'confirmada',
                  'text-red-600' => $c->estado === 'cancelada',
              ])">{{ $c->estado }}</span>
            </td>
            <td class="p-3 border text-right">$ {{ number_format($c->total, 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center py-4 text-gray-500">No tienes citas registradas.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</x-app-layout>
