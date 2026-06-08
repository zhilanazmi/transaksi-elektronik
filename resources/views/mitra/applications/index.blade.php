<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Mitra Center</p>
                <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">Pengajuan Mitra</h2>
                <p class="mt-1 text-sm text-stone-400">Kelola pengajuan kemitraan, status persetujuan, dan kontrak kerjasama.</p>
            </div>
            <a class="inline-flex justify-center rounded-2xl bg-amber-500 px-5 py-3 text-sm font-black text-stone-950 transition hover:-translate-y-0.5 hover:bg-amber-400" href="{{ route('mitra.applications.create') }}">
                Ajukan Mitra
            </a>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm font-semibold text-emerald-200">{{ session('success') }}</div>
            @endif

            <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 shadow-2xl shadow-black/20">
                @forelse($applications as $application)
                    <a href="{{ route('mitra.applications.show', $application) }}" class="block border-b border-white/10 p-5 transition last:border-b-0 hover:bg-white/[0.05] sm:p-6">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div class="min-w-0">
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-stone-500">ID: {{ $application->id }}</p>
                                <h3 class="mt-2 truncate text-xl font-black text-white">{{ $application->nama_mitra }}</h3>
                                <p class="mt-2 text-sm text-stone-400">{{ ucfirst($application->jenis_mitra) }} - {{ $application->produk_mitra }}</p>
                            </div>
                            <div class="flex flex-col gap-2 md:items-end">
                                <p class="text-sm text-stone-400">Durasi: {{ $application->durasi_mitra }}</p>
                                <span class="w-fit rounded-full px-3 py-1 text-xs font-black capitalize {{ $application->status === 'approved' ? 'bg-emerald-400/15 text-emerald-300' : ($application->status === 'rejected' ? 'bg-red-400/15 text-red-300' : 'bg-amber-400/15 text-amber-300') }}">
                                    {{ $application->status }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-10 text-center">
                        <p class="text-lg font-black text-white">Belum ada pengajuan kemitraan.</p>
                        <p class="mt-2 text-sm text-stone-400">Ajukan kemitraan pertama Anda untuk mulai bekerja sama dengan kami.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
