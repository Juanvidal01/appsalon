@props(['variant' => 'primary'])
@php
$base = 'inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-medium';
$map = [
  'primary' => $base.' bg-brand-600 text-white hover:bg-brand-700 shadow-sm',
  'secondary' => $base.' bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700',
  'danger' => $base.' bg-red-600 text-white hover:bg-red-700',
];
@endphp
<button {{ $attributes->merge(['class' => $map[$variant] ?? $map['primary']]) }}>
  {{ $slot }}
</button>