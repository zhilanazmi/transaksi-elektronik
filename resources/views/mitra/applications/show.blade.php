<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Detail Pengajuan</p>
                <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">{{ $application->nama_mitra }}</h2>
                <p class="mt-1 text-sm text-stone-400">Status pengajuan kemitraan Anda.</p>
            </div>
            @if($application->status === 'approved' && $application->contract)
                <a class="inline-flex justify-center rounded-2xl bg-amber-500 px-5 py-3 text-sm font-black text-stone-950 transition hover:-translate-y-0.5 hover:bg-amber-400" href="{{ route('contracts.download', $application->contract) }}">
                    Download Kontrak
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-8">
                    <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20 sm:p-10">
                        <h3 class="text-xl font-black text-white mb-6">Detail Pengajuan</h3>
                        <div class="space-y-6">
                            <div>
                                <p class="text-xs font-black uppercase tracking-wider text-stone-500">Jenis Mitra</p>
                                <p class="mt-1 text-lg font-bold text-white">{{ ucfirst($application->jenis_mitra) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-wider text-stone-500">Produk</p>
                                <p class="mt-1 text-lg font-bold text-white">{{ $application->produk_mitra }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-wider text-stone-500">Durasi</p>
                                <p class="mt-1 text-lg font-bold text-white">{{ $application->durasi_mitra }}</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t border-white/10">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-wider text-stone-500 mb-2">Kewajiban Mitra</p>
                                    <div class="text-stone-300 text-sm whitespace-pre-line leading-relaxed">
                                        {{ $application->kewajiban_mitra }}
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-black uppercase tracking-wider text-stone-500 mb-2">Kewajiban Pemilik</p>
                                    <div class="text-stone-300 text-sm whitespace-pre-line leading-relaxed">
                                        {{ $application->kewajiban_pemilik }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($application->status === 'approved' && $application->contract)
                        <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20 sm:p-10">
                            <h3 class="text-xl font-black text-white mb-6">Kontrak Kerjasama</h3>
                            <div class="rounded-xl bg-stone-950 p-6 font-mono text-sm text-amber-200/80 border border-amber-500/10 whitespace-pre-line leading-relaxed">
                                {{ $application->contract->content }}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-8">
                    <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20">
                        <h3 class="text-sm font-black uppercase tracking-wider text-stone-500 mb-4">Status Saat Ini</h3>
                        <div class="flex items-center gap-3">
                            <span class="flex h-3 w-3 rounded-full {{ $application->status === 'approved' ? 'bg-emerald-500' : ($application->status === 'rejected' ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                            <span class="text-xl font-black capitalize text-white">{{ $application->status }}</span>
                        </div>
                        
                        @if($application->admin_notes)
                            <div class="mt-6 pt-6 border-t border-white/10">
                                <p class="text-xs font-black uppercase tracking-wider text-stone-500 mb-2">Catatan Admin</p>
                                <p class="text-sm text-stone-300 italic">"{{ $application->admin_notes }}"</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
