<x-guest-layout>
  <h2 class="auth-title">Crear cuenta</h2>

  @if ($errors->any())
    <div class="mb-4 text-red-700 bg-red-100 border border-red-300 rounded p-3 text-sm">
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf

    <div>
      <label for="name" class="label">Nombre</label>
      <input id="name" name="name" type="text" value="{{ old('name') }}" required class="input">
    </div>

    <div>
      <label for="telefono" class="label">Teléfono</label>
      <input id="telefono" name="telefono" type="text" value="{{ old('telefono') }}" required class="input">
    </div>

    <div>
      <label for="email" class="label">Correo electrónico</label>
      <input id="email" name="email" type="email" value="{{ old('email') }}" required class="input">
    </div>

    <div>
      <label for="password" class="label">Contraseña</label>
      <input id="password" name="password" type="password" required class="input">
    </div>

    <div>
      <label for="password_confirmation" class="label">Confirmar contraseña</label>
      <input id="password_confirmation" name="password_confirmation" type="password" required class="input">
    </div>

    <button type="submit" class="w-full btn-primary">Registrarme</button>

    <p class="mt-4 text-center muted">
      ¿Ya tienes cuenta?
      <a href="{{ route('login') }}" class="text-[var(--c-brand)] hover:text-[var(--c-brand-700)] font-medium">Inicia sesión</a>
    </p>
  </form>
</x-layouts.guest>
