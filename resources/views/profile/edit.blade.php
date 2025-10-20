<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                {{-- Avatar simple con inicial --}}
                <div class="w-10 h-10 rounded-full bg-indigo-600 text-white grid place-items-center font-semibold">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-semibold leading-tight">
                        Perfil de {{ auth()->user()->name }}
                    </h2>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>

            {{-- Botón Cerrar sesión visible --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-secondary" title="Cerrar sesión">
                    {{-- Icono Logout --}}
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                              d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                              d="M10 17l5-5-5-5" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                              d="M15 12H3" />
                    </svg>
                    <span>Salir</span>
                </button>
            </form>
        </div>
    </x-slot>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Tarjeta: Datos de cuenta --}}
        <div class="lg:col-span-2 card">
            <div class="card-pad">
                <div class="flex items-center gap-2 mb-4">
                    {{-- Icono User --}}
                    <svg class="icon text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                              d="M20 21a8 8 0 0 0-16 0" />
                        <circle cx="12" cy="7" r="4" stroke-width="1.6"/>
                    </svg>
                    <h3 class="text-lg font-semibold">Datos de cuenta</h3>
                </div>

                {{-- Estados/errores --}}
                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-green-50 text-green-800 border border-green-200 p-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 text-red-800 border border-red-200 p-3 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" class="grid sm:grid-cols-2 gap-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="label">Nombre</label>
                        <input class="input" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div>
                        <label class="label">Apellido</label>
                        <input class="input" type="text" name="apellido" value="{{ old('apellido', auth()->user()->apellido) }}" required>
                    </div>

                    <div>
                        <label class="label">Teléfono</label>
                        <input class="input" type="text" name="telefono" value="{{ old('telefono', auth()->user()->telefono) }}">
                    </div>

                    <div>
                        <label class="label">Correo</label>
                        <input class="input" type="email" value="{{ auth()->user()->email }}" disabled>
                    </div>

                    <div class="sm:col-span-2 mt-2 flex items-center gap-2">
                        <button class="btn-primary">
                            {{-- Icono Guardar --}}
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                      d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                      d="M17 21V13H7v8" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                      d="M7 3v4h8" />
                            </svg>
                            Guardar cambios
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tarjeta: Seguridad (cambiar contraseña opcional) --}}
        <div class="card">
            <div class="card-pad">
                <div class="flex items-center gap-2 mb-4">
                    {{-- Icono Lock --}}
                    <svg class="icon text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                              d="M16 10V8a4 4 0 1 0-8 0v2" />
                        <rect x="4" y="10" width="16" height="10" rx="2" ry="2" stroke-width="1.6" />
                    </svg>
                    <h3 class="text-lg font-semibold">Seguridad</h3>
                </div>

                {{-- Si manejas password en otra ruta, cambia el action --}}
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="label">Nueva contraseña</label>
                        <input class="input" type="password" name="password">
                    </div>
                    <div>
                        <label class="label">Confirmar contraseña</label>
                        <input class="input" type="password" name="password_confirmation">
                    </div>
                    <button class="btn-secondary w-full">Actualizar contraseña</button>
                </form>
            </div>
        </div>

        {{-- Tarjeta: Eliminar cuenta --}}
        <div class="lg:col-span-3 card">
            <div class="card-pad">
                <div class="flex items-center gap-2 mb-2">
                    {{-- Icono Alert --}}
                    <svg class="icon text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                              d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" stroke-width="1.6"/>
                        <line x1="12" y1="17" x2="12.01" y2="17" stroke-width="1.6"/>
                    </svg>
                    <h3 class="text-lg font-semibold">Zona peligrosa</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                    Esta acción es irreversible. Se eliminarán tus datos y citas asociadas.
                </p>

                <form method="POST" action="{{ route('profile.destroy') }}"
                      onsubmit="return confirm('¿Seguro que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button class="btn-danger">
                        Eliminar mi cuenta
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
