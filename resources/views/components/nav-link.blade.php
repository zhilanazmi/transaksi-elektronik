@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-full bg-amber-500 px-4 py-2 text-sm font-black leading-5 text-stone-950 transition duration-150 ease-in-out focus:outline-none'
            : 'inline-flex items-center rounded-full px-4 py-2 text-sm font-bold leading-5 text-stone-300 transition duration-150 ease-in-out hover:bg-white/10 hover:text-white focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
