<x-guest-layout>
  <h2 class="auth-title">Iniciar sesión</h2>

  @if (session('status'))
    <div class="mb-4 text-green-700 bg-green-100 border border-green-300 rounded p-3 text-sm">
      {{ session('status') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="mb-4 text-red-700 bg-red-100 border border-red-300 rounded p-3 text-sm">
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf
    <div>
      <label for="email" class="label">Correo electrónico</label>
      <input id="email" name="email" type="email" required autofocus class="input">
    </div>

    <div>
      <label for="password" class="label">Contraseña</label>
      <input id="password" name="password" type="password" required class="input">
    </div>

    <div class="flex items-center justify-between">
      <label class="flex items-center text-sm text-gray-700">
        <input type="checkbox" name="remember" class="checkbox">
        <span class="ml-2">Recordarme</span>
      </label>
      @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="text-sm text-[var(--c-brand)] hover:text-[var(--c-brand-700)] font-medium">
          ¿Olvidaste tu contraseña?
        </a>
      @endif
    </div>

    <button type="submit" class="w-full btn-primary">Ingresar</button>

    <p class="mt-4 text-center muted">
      ¿No tienes cuenta?
      <a href="{{ route('register') }}" class="text-[var(--c-brand)] hover:text-[var(--c-brand-700)] font-medium">Regístrate aquí</a>
    </p>
  </form>
</x-layouts.guest>
