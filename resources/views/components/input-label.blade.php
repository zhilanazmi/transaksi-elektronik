@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-black text-stone-300']) }}>
    {{ $value ?? $slot }}
</label>
