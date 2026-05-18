<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Detail Proyek</p>
            <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">{{ $project->title }}</h2>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm font-semibold text-emerald-200 lg:col-span-3">{{ session('status') }}</div>
            @endif

            <section class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20 lg:col-span-2">
                <p class="text-xs font-black uppercase tracking-[0.24em] text-stone-500">{{ $project->project_code }}</p>
                <h3 class="mt-3 text-3xl font-black text-white">{{ $project->title }}</h3>
                <p class="mt-4 leading-7 text-stone-300">{{ $project->description }}</p>

                <dl class="mt-8 grid gap-4 sm:grid-cols-2">
                    @foreach([
                        ['Jenis', $project->construction_type],
                        ['Lokasi', $project->location],
                        ['Budget', 'Rp'.number_format($project->budget, 0, ',', '.')],
                        ['Sisa Tagihan', 'Rp'.number_format($project->remainingAmount(), 0, ',', '.')],
                    ] as $item)
                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                            <dt class="text-sm font-semibold text-stone-400">{{ $item[0] }}</dt>
                            <dd class="mt-1 font-black text-white">{{ $item[1] }}</dd>
                        </div>
                    @endforeach
                </dl>

                @if($project->contract)
                    <div class="mt-6 rounded-3xl border border-amber-300/30 bg-amber-300/10 p-5">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-sm font-black text-amber-200">Kontrak {{ $project->contract->contract_number }}</p>
                                <p class="mt-2 text-sm leading-6 text-stone-300">Kontrak formal sudah tersedia dan dapat diekspor sebagai PDF.</p>
                            </div>
                            <a href="{{ route('contracts.download', $project->contract) }}" class="rounded-2xl bg-amber-500 px-4 py-3 text-center text-sm font-black text-stone-950 transition hover:bg-amber-400">Download PDF</a>
                        </div>
                    </div>
                @endif
            </section>

            <aside class="space-y-5">
                <div class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-xl shadow-black/20">
                    <p class="text-sm font-semibold text-stone-400">Status</p>
                    <p class="mt-2 w-fit rounded-full px-4 py-2 text-sm font-black capitalize {{ $project->status === 'approved' ? 'bg-emerald-400/15 text-emerald-300' : ($project->status === 'waiting_payment' ? 'bg-sky-400/15 text-sky-300' : ($project->status === 'rejected' ? 'bg-red-400/15 text-red-300' : 'bg-amber-400/15 text-amber-300')) }}">
                        {{ str_replace('_', ' ', $project->status) }}
                    </p>
                    @if($project->admin_notes)
                        <p class="mt-4 rounded-2xl bg-white/[0.04] p-4 text-sm leading-6 text-stone-300">{{ $project->admin_notes }}</p>
                    @endif
                </div>

                @if(in_array($project->status, ['waiting_payment', 'approved'], true) && $project->user_id === auth()->id())
                    <a href="{{ route('payments.create', $project) }}" class="block rounded-2xl bg-amber-500 px-5 py-4 text-center font-black text-stone-950 transition hover:-translate-y-0.5 hover:bg-amber-400">Buat Pembayaran</a>
                @endif
                @if($project->status === 'pending' && $project->user_id === auth()->id())
                    <a href="{{ route('projects.edit', $project) }}" class="block rounded-2xl border border-white/10 bg-white/5 px-5 py-4 text-center font-black text-white transition hover:bg-white/10">Edit Pengajuan</a>
                @endif
            </aside>

            <section class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20 lg:col-span-3">
                <h3 class="text-xl font-black text-white">Riwayat Pembayaran</h3>
                <div class="mt-5 grid gap-3">
                    @forelse($project->payments as $payment)
                        <div class="rounded-3xl border border-white/10 bg-white/[0.04] p-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-black text-white">{{ $payment->invoice_number }}</p>
                                    <p class="mt-1 text-sm uppercase text-stone-400">{{ $payment->method }} - {{ $payment->status }}</p>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="font-black text-white">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                                    @if((auth()->user()->isAdmin() || auth()->user()->isStaff()) && $payment->status === 'pending')
                                        <form method="POST" action="{{ route('payments.paid', $payment) }}" class="mt-2">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded-xl bg-emerald-500 px-3 py-2 text-xs font-black text-white">Tandai Lunas</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            @if($payment->method === 'qris')
                                <div x-data="{ open: false }" class="mt-4 w-fit">
                                    <button type="button" @click="open = true" class="group rounded-3xl border border-white/10 bg-white p-3 transition hover:-translate-y-0.5 hover:border-amber-300/60 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-stone-900">
                                        <img src="{{ asset('images/qris.jpeg') }}" alt="Kode QRIS pembayaran" class="h-48 w-48 rounded-2xl object-contain">
                                        <span class="mt-3 block text-center text-xs font-black uppercase tracking-[0.2em] text-stone-700 group-hover:text-amber-700">Klik untuk perbesar</span>
                                    </button>

                                    <div x-cloak x-show="open" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm" @click.self="open = false" @keydown.escape.window="open = false">
                                        <div x-show="open" x-transition.scale.origin.center class="relative w-full max-w-xl rounded-[2rem] border border-white/10 bg-stone-950 p-4 shadow-2xl shadow-black/50 sm:p-6">
                                            <button type="button" @click="open = false" class="absolute right-4 top-4 rounded-full bg-white/10 px-3 py-2 text-sm font-black text-white transition hover:bg-white/20" aria-label="Tutup QRIS">
                                                X
                                            </button>
                                            <div class="pt-10 sm:pt-8">
                                                <div class="rounded-3xl bg-white p-4">
                                                    <img src="{{ asset('images/qris.jpeg') }}" alt="Kode QRIS pembayaran diperbesar" class="mx-auto max-h-[72vh] w-full object-contain">
                                                </div>
                                                <p class="mt-4 text-center text-sm font-semibold text-stone-300">Scan QRIS untuk menyelesaikan pembayaran.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="rounded-3xl border border-dashed border-white/20 p-8 text-center text-stone-400">Belum ada pembayaran.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
