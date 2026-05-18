@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-2xl bg-amber-500 px-4 py-3 text-start text-base font-black text-stone-950 transition duration-150 ease-in-out focus:outline-none'
            : 'block w-full rounded-2xl px-4 py-3 text-start text-base font-bold text-stone-300 transition duration-150 ease-in-out hover:bg-white/10 hover:text-white focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
