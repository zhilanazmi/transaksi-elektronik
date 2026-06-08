<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Review Pengajuan</p>
                <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">{{ $application->nama_mitra }}</h2>
                <p class="mt-1 text-sm text-stone-400">Oleh: {{ $application->user->name }} ({{ $application->user->email }})</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-8">
                    <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20 sm:p-10">
                        <h3 class="text-xl font-black text-white mb-6">Informasi Mitra</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                            <div>
                                <p class="text-xs font-black uppercase tracking-wider text-stone-500">Tanggal Pengajuan</p>
                                <p class="mt-1 text-lg font-bold text-white">{{ $application->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-white/10 space-y-8">
                            <div>
                                <p class="text-xs font-black uppercase tracking-wider text-stone-500 mb-2">Kewajiban Mitra</p>
                                <div class="text-stone-300 text-sm whitespace-pre-line leading-relaxed bg-stone-950 p-4 rounded-xl border border-white/5">
                                    {{ $application->kewajiban_mitra }}
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-wider text-stone-500 mb-2">Kewajiban Pemilik</p>
                                <div class="text-stone-300 text-sm whitespace-pre-line leading-relaxed bg-stone-950 p-4 rounded-xl border border-white/5">
                                    {{ $application->kewajiban_pemilik }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20">
                        <h3 class="text-sm font-black uppercase tracking-wider text-stone-500 mb-6">Keputusan Admin</h3>
                        
                        @if($application->status === 'pending')
                            <form method="POST" action="{{ route('admin.mitra.approve', $application) }}" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <x-input-label for="admin_notes_approve" value="Catatan (Opsional)" class="text-stone-300 text-xs" />
                                    <textarea id="admin_notes_approve" name="admin_notes" rows="3" class="mt-1 block w-full rounded-xl border-white/10 bg-stone-950 text-white text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Tambahkan catatan persetujuan..."></textarea>
                                </div>
                                <button type="submit" class="w-full rounded-xl bg-emerald-500 py-3 text-sm font-black text-stone-950 transition hover:bg-emerald-400">
                                    Setujui Pengajuan
                                </button>
                            </form>

                            <div class="relative my-6">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-white/10"></div>
                                </div>
                                <div class="relative flex justify-center text-xs font-black uppercase">
                                    <span class="bg-stone-900 px-2 text-stone-600">Atau</span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('admin.mitra.reject', $application) }}" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <x-input-label for="admin_notes_reject" value="Alasan Penolakan" class="text-stone-300 text-xs" />
                                    <textarea id="admin_notes_reject" name="admin_notes" rows="3" class="mt-1 block w-full rounded-xl border-white/10 bg-stone-950 text-white text-sm focus:border-red-500 focus:ring-red-500" required placeholder="Sebutkan alasan penolakan..."></textarea>
                                </div>
                                <button type="submit" class="w-full rounded-xl bg-red-500/10 border border-red-500/50 py-3 text-sm font-black text-red-500 transition hover:bg-red-500/20">
                                    Tolak Pengajuan
                                </button>
                            </form>
                        @else
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex h-3 w-3 rounded-full {{ $application->status === 'approved' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                <span class="text-xl font-black capitalize text-white">{{ $application->status }}</span>
                            </div>
                            @if($application->admin_notes)
                                <div class="p-4 rounded-xl bg-stone-950 border border-white/5 italic text-sm text-stone-400">
                                    "{{ $application->admin_notes }}"
                                </div>
                            @endif
                            @if($application->status === 'approved' && $application->contract)
                                <a href="{{ route('contracts.download', $application->contract) }}" class="mt-6 inline-flex w-full justify-center rounded-xl border border-white/10 py-3 text-sm font-black text-white hover:bg-white/5">
                                    Lihat Kontrak
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
