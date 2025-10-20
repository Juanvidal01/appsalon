<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? config('app.name', 'AppSalon') }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="page">
  {{-- Navbar --}}
  <header class="navbar">
    <div class="navbar-inner">
      <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
        <span class="inline-block w-9 h-9 rounded-lg bg-[var(--c-brand)]"></span>
        <span class="text-xl font-semibold">AppSalon</span>
      </a>

     <nav class="hidden md:flex items-center gap-2">
  @auth
    @if(auth()->user()->admin)
      {{-- Admin --}}
      <a href="{{ route('admin.dashboard') }}" class="btn-outline">Dashboard</a>
      <a href="{{ route('admin.servicios.index') }}" class="btn-outline">Gestionar servicios</a>
      <a href="{{ route('profile.edit') }}" class="btn-outline">Perfil</a>
      <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button class="btn-outline">Salir</button>
      </form>
    @else
      {{-- Cliente (sin "Servicios" en nav) --}}
      <a href="{{ route('citas.create') }}" class="btn-outline">Reservar</a>
      <a href="{{ route('citas.index') }}" class="btn-outline">Mis citas</a>
      <a href="{{ route('profile.edit') }}" class="btn-outline">Perfil</a>
      <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button class="btn-outline">Salir</button>
      </form>
    @endif
  @endauth
</nav>
    </div>
  </header>

  {{-- Header de página --}}
  @isset($header)
    <div class="page-header">
      <h1 class="page-header-title">{{ $header }}</h1>
      {{ $actions ?? '' }}
    </div>
  @endisset

  {{-- Contenido principal --}}
  <main class="wrapper py-6">
    {{ $slot }}
  </main>

  <footer class="mt-16 py-8 border-t border-gray-200">
    <div class="wrapper text-sm text-gray-500 flex items-center justify-between">
      <span>© {{ date('Y') }} AppSalon</span>
      <span>Laravel + Tailwind</span>
    </div>
  </footer>
</body>
</html>
