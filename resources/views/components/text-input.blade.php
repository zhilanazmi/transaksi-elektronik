@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl border-white/10 bg-stone-950 text-stone-100 shadow-sm focus:border-amber-500 focus:ring-amber-500']) }}>
