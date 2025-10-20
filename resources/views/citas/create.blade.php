<x-app-layout>
  <x-slot name="header">
    Reservar Cita
  </x-slot>

  <div class="max-w-3xl mx-auto mt-8 bg-white shadow p-6 rounded-lg">
    {{-- Mensajes de error --}}
    @if ($errors->any())
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <ul class="list-disc ml-4">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Formulario --}}
    <form method="GET" action="{{ route('citas.create') }}" class="mb-6">
      <label for="fecha" class="block font-semibold text-gray-700">Selecciona la fecha</label>
      <div class="flex items-center gap-3 mt-2">
        <input
          type="date"
          id="fecha"
          name="fecha"
          value="{{ request('fecha') }}"
          required
          class="border border-gray-300 rounded p-2"
        >
        <button type="submit" class="btn-primary bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
          Ver disponibilidad
        </button>
      </div>
    </form>

    @if (request('fecha'))
      <form method="POST" action="{{ route('citas.store') }}">
        @csrf

        <input type="hidden" name="fecha" value="{{ request('fecha') }}">

        {{-- Horarios disponibles --}}
        <div class="mb-4">
          <label class="block font-semibold text-gray-700">Hora disponible</label>
          <select name="hora" class="w-full border border-gray-300 rounded p-2" required>
            <option value="">Selecciona una hora</option>
            @forelse ($slots ?? [] as $slot)
              <option value="{{ $slot }}">{{ $slot }}</option>
            @empty
              <option disabled>No hay horarios disponibles</option>
            @endforelse
          </select>
        </div>

        {{-- Servicios --}}
        <div class="mb-6">
          <label class="block font-semibold text-gray-700 mb-2">Selecciona los servicios</label>
          <div class="grid sm:grid-cols-2 gap-3">
            @foreach ($servicios as $servicio)
              <label class="flex items-center space-x-2 border p-2 rounded hover:bg-gray-50">
                <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}">
                <span>{{ $servicio->nombre }} - <span class="text-sm text-gray-500">${{ number_format($servicio->precio, 0, ',', '.') }}</span></span>
              </label>
            @endforeach
          </div>
        </div>

        {{-- Botón --}}
        <div class="mt-6">
          <button type="submit" class="btn-primary w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            Reservar cita
          </button>
        </div>
      </form>
    @endif
  </div>
</x-app-layout>
