<x-app-layout>
  <x-slot name="header">
    Panel de Administración
  </x-slot>

  <x-slot name="actions">
    <div class="flex items-center gap-3">
      {{-- ✅ Botón de Gestionar Servicios (volvió aquí) --}}
      <a href="{{ route('admin.servicios.index') }}" class="btn-primary">Gestionar servicios</a>

      {{-- Filtro por fecha --}}
      <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-end gap-2">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Fecha</label>
          <input type="date" name="fecha" value="{{ $fecha }}" class="input">
        </div>
        <button class="btn-secondary">Filtrar</button>
      </form>

      {{-- Botón de Cerrar sesión --}}
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-outline">Cerrar sesión</button>
      </form>
    </div>
  </x-slot>

  {{-- Flash message --}}
  @if(session('ok'))
    <div class="wrapper">
      <div class="mb-4 text-green-700 bg-green-100 border border-green-300 rounded p-3 text-sm">
        {{ session('ok') }}
      </div>
    </div>
  @endif

  <div class="grid-dashboard">
    {{-- KPIs y top servicios --}}
    <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
      <div class="kpi">
        <div class="muted">Citas ({{ \Illuminate\Support\Carbon::parse($fecha)->format('Y-m-d') }})</div>
        <div class="mt-1 text-2xl font-bold">{{ $stats['citas_dia'] ?? 0 }}</div>
      </div>
      <div class="kpi">
        <div class="muted">Ingresos netos (día)</div>
        <div class="mt-1 text-2xl font-bold">$ {{ number_format($stats['ingresos_dia'] ?? 0, 0, ',', '.') }}</div>
        <div class="text-xs text-gray-500 mt-1">Excluye citas canceladas</div>
      </div>

      <div class="panel">
        <div class="card-pad">
          <div>
            <div class="muted">Top servicios</div>
            <div class="text-xs text-gray-400">
              {{ $rangoTop[0] ?? now()->subDays(30)->toDateString() }} — {{ $rangoTop[1] ?? now()->toDateString() }}
            </div>
          </div>

          <div class="mt-3 space-y-3">
            @forelse(($topServicios ?? collect()) as $t)
              <div class="flex items-center justify-between">
                <div class="text-sm text-gray-800">{{ $t->nombre }}</div>
                <div class="text-right">
                  <div class="text-sm font-semibold">{{ $t->usos }} usos</div>
                  <div class="text-xs text-gray-500">$ {{ number_format($t->ingresos, 0, ',', '.') }}</div>
                </div>
              </div>
            @empty
              <div class="text-sm text-gray-500">Sin datos aún.</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    {{-- Agenda del día --}}
    <div class="lg:col-span-2 panel">
      <div class="card-pad">
        <div class="flex items-center justify-between mb-3">
          <h3 class="section-title">Agenda del día</h3>
          <span class="muted">{{ ($citasDia ?? collect())->count() }} cita(s)</span>
        </div>

        <div class="table-wrap">
          <table class="table">
            <thead class="thead">
              <tr>
                <th class="th">Hora</th>
                <th class="th">Cliente</th>
                <th class="th">Servicios</th>
                <th class="th">Estado</th>
                <th class="th text-right">Total</th>
                <th class="th text-right">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse(($citasDia ?? collect()) as $c)
                <tr class="tr">
                  <td class="td">{{ $c->hora->format('H:i') }} - {{ $c->hora_fin->format('H:i') }}</td>
                  <td class="td">{{ $c->usuario?->name }}</td>
                  <td class="td">{{ $c->servicios->pluck('nombre')->join(', ') }}</td>
                  <td class="td">
                    <span class="@class([
                        'badge-yellow' => $c->estado==='pendiente',
                        'badge-blue' => $c->estado==='confirmada',
                        'badge-red' => $c->estado==='cancelada',
                      ])">{{ ucfirst($c->estado) }}</span>
                  </td>
                  <td class="td text-right">$ {{ number_format($c->total, 0, ',', '.') }}</td>
                  <td class="td text-right">
                    @if($c->estado !== 'cancelada')
                      <form method="POST" action="{{ route('admin.citas.cancel', $c) }}"
                            onsubmit="return confirm('¿Cancelar esta cita?');" class="inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn-danger">Cancelar</button>
                      </form>
                    @else
                      <span class="badge-red">Cancelada</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr><td colspan="6" class="td text-center muted py-6">Sin citas para esta fecha.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
