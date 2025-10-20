@props(['type' => 'success'])
@php
$styles = [
  'success' => 'bg-green-50 text-green-800 border-green-200 dark:bg-green-900/20 dark:text-green-200 dark:border-green-900',
  'error'   => 'bg-red-50 text-red-800 border-red-200 dark:bg-red-900/20 dark:text-red-200 dark:border-red-900',
  'info'    => 'bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-900/20 dark:text-blue-200 dark:border-blue-900',
];
@endphp
<div {{ $attributes->merge(['class' => 'p-3 rounded-lg border '.$styles[$type]]) }}>
  {{ $slot }}
</div>