@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-blue-500 font-extrabold']) }}>
    {{ $value ?? $slot }}
</label>