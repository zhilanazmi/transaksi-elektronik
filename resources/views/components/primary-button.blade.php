<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-xl border border-transparent bg-amber-500 px-5 py-2.5 text-xs font-black uppercase tracking-widest text-stone-950 shadow-lg shadow-amber-500/20 transition ease-in-out duration-150 hover:bg-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-stone-900']) }}>
    {{ $slot }}
</button>
