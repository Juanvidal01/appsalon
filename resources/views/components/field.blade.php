@props(['label' => null, 'name' => null, 'type' => 'text'])
<label class="label">{{ $label }}</label>
<input type="{{ $type }}" name="{{ $name }}" {{ $attributes->merge(['class'=>'input']) }} value="{{ old($name, $slot) }}">
@error($name) <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror