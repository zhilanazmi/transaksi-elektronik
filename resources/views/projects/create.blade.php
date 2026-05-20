<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Pengajuan</p>
            <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">Ajukan Pesanan Laundry</h2>
        </div>
    </x-slot>
    <div class="py-8 sm:py-10"><div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('projects.store') }}" class="space-y-5 rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20">
            @csrf
            @include('projects.partials.form')
            <button class="w-full rounded-2xl bg-amber-500 px-5 py-4 font-black text-stone-950 transition hover:bg-amber-400">Kirim Pengajuan</button>
        </form>
    </div></div>
</x-app-layout>
