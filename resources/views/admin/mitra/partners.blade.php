<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Admin Panel</p>
            <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">Daftar Mitra Aktif</h2>
            <p class="mt-1 text-sm text-stone-400">Daftar mitra yang telah disetujui dan aktif bekerja sama.</p>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($partners as $partner)
                    <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-500/20 text-amber-500 font-black text-xl">
                                {{ strtoupper(substr($partner->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-black text-white text-lg">{{ $partner->name }}</h3>
                                <p class="text-xs text-stone-500">{{ $partner->email }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($partner->mitraApplications()->where('status', 'approved')->get() as $app)
                                <div class="p-4 rounded-xl bg-stone-950 border border-white/5">
                                    <p class="text-xs font-black text-amber-500 uppercase tracking-widest mb-1">{{ $app->nama_mitra }}</p>
                                    <p class="text-sm text-stone-300">{{ ucfirst($app->jenis_mitra) }} - {{ $app->produk_mitra }}</p>
                                    <div class="mt-3 flex justify-between items-center">
                                        <span class="text-[10px] text-stone-500">Durasi: {{ $app->durasi_mitra }}</span>
                                        @if($app->contract)
                                            <a href="{{ route('contracts.download', $app->contract) }}" class="text-[10px] font-black text-amber-500 hover:text-amber-400">LIHAT KONTRAK</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-10 text-center text-stone-500 font-bold bg-stone-900/80 rounded-[2rem] border border-white/10">
                        Belum ada mitra yang disetujui.
                    </div>
                @endforelse
            </div>
            <div class="mt-6">{{ $partners->links() }}</div>
        </div>
    </div>
</x-app-layout>
