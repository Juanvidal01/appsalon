{{-- resources/views/servicios/index.blade.php --}}
<x-guest-layout>
  <div class="card card-pad">
    <h1 class="text-2xl font-bold mb-4">Servicios</h1>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($servicios as $s)
        <div class="card">
          <div class="card-pad">
            <div class="font-semibold">{{ $s->nombre }}</div>
            <div class="text-gray-600 dark:text-gray-300 mt-1">$ {{ number_format($s->precio,0,',','.') }}</div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="mt-4">{{ $servicios->links() }}</div>
  </div>
</x-guest-layout>
