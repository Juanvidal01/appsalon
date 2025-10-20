<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold">Hola, {{ $user->name }} 👋</h2>
                <p class="text-sm text-gray-500">Bienvenido a tu panel de AppSalon</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('citas.create') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm">Reservar cita</a>
                <a href="{{ route('citas.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Mis citas</a>
            </div>
        </div>
    </x-slot>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Próxima cita --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-card border border-gray-100 dark:border-gray-800 p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Tu próxima cita</h3>
                    @if($proxima)
                        <span class="text-xs px-2 py-1 rounded bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-200">
                            {{ ucfirst($proxima->estado) }}
                        </span>
                    @endif
                </div>

                @if($proxima)
                    <div class="mt-4 grid sm:grid-cols-3 gap-4">
                        <div>
                            <div class="text-sm text-gray-500">Fecha</div>
                            <div class="font-medium">{{ $proxima->fecha->format('Y-m-d') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Hora</div>
                            <div class="font-medium">{{ $proxima->hora->format('H:i') }} — {{ $proxima->hora_fin->format('H:i') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Servicios</div>
                            <div class="font-medium">{{ $proxima->servicios->pluck('nombre')->join(', ') }}</div>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        Total: <span class="font-semibold text-gray-900 dark:text-gray-200">
                            $ {{ number_format($proxima->total, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="mt-6 flex items-center gap-2">
                        <a href="{{ route('citas.create', ['fecha' => $proxima->fecha->format('Y-m-d')]) }}" class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm">Reprogramar</a>
                    </div>
                @else
                    <div class="mt-4 text-gray-600">No tienes citas próximas. ¿Agendamos una?</div>
                    <a href="{{ route('citas.create') }}" class="mt-4 inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm">Nueva reserva</a>
                @endif
            </div>

            {{-- Historial reciente --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-card border border-gray-100 dark:border-gray-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Tu historial reciente</h3>
                    <a href="{{ route('citas.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Ver todas</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left border-b border-gray-200 dark:border-gray-800">
                                <th class="py-2 pr-4">Fecha</th>
                                <th class="py-2 pr-4">Hora</th>
                                <th class="py-2 pr-4">Servicios</th>
                                <th class="py-2 pr-4">Estado</th>
                                <th class="py-2 pr-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimas as $c)
                            <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50/60 dark:hover:bg-gray-800/40">
                                <td class="py-2 pr-4">{{ $c->fecha->format('Y-m-d') }}</td>
                                <td class="py-2 pr-4">{{ $c->hora->format('H:i') }} - {{ $c->hora_fin->format('H:i') }}</td>
                                <td class="py-2 pr-4">{{ $c->servicios->pluck('nombre')->join(', ') }}</td>
                                <td class="py-2 pr-4">
                                    <span class="inline-block text-xs px-2 py-1 rounded
                                        @class([
                                            'bg-yellow-50 text-yellow-700' => $c->estado==='pendiente',
                                            'bg-blue-50 text-blue-700' => $c->estado==='confirmada',
                                            'bg-red-50 text-red-700' => $c->estado==='cancelada',
                                        ])">
                                        {{ ucfirst($c->estado) }}
                                    </span>
                                </td>
                                <td class="py-2 pr-2 text-right">$ {{ number_format($c->total, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="py-4 text-center text-gray-500">Aún no tienes citas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Métricas + accesos --}}
        <div class="space-y-6">
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-card border border-gray-100 dark:border-gray-800 p-5">
                    <div class="text-sm text-gray-500">Citas totales</div>
                    <div class="mt-1 text-2xl font-bold">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-card border border-gray-100 dark:border-gray-800 p-5">
                    <div class="text-sm text-gray-500">Pendientes</div>
                    <div class="mt-1 text-2xl font-bold">{{ $stats['pendientes'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-card border border-gray-100 dark:border-gray-800 p-5">
                    <div class="text-sm text-gray-500">Confirmadas</div>
                    <div class="mt-1 text-2xl font-bold">{{ $stats['confirmadas'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-card border border-gray-100 dark:border-gray-800 p-5">
                    <div class="text-sm text-gray-500">Canceladas</div>
                    <div class="mt-1 text-2xl font-bold">{{ $stats['canceladas'] }}</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-card border border-gray-100 dark:border-gray-800 p-6">
                <h3 class="text-lg font-semibold mb-3">Accesos rápidos</h3>
                <div class="grid sm:grid-cols-2 gap-3">
                    <a href="{{ route('servicios.index') }}" class="px-4 py-3 rounded-lg bg-gray-100 hover:bg-gray-200 text-center">Ver servicios</a>
                    <a href="{{ route('citas.create') }}" class="px-4 py-3 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 text-center">Nueva cita</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
