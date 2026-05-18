<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.35em] text-amber-400">ConstructPay</p>
                <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">Dashboard Konstruksi</h2>
                <p class="mt-1 text-sm text-stone-400">Pantau pengajuan, pembayaran, dan progres proyek dari satu tempat.</p>
            </div>
            <a href="{{ route('projects.create') }}" class="inline-flex justify-center rounded-2xl bg-amber-500 px-5 py-3 text-sm font-black text-stone-950 shadow-lg shadow-amber-500/20 transition hover:-translate-y-0.5 hover:bg-amber-400">
                Ajukan Proyek
            </a>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm font-semibold text-emerald-200">{{ session('status') }}</div>
            @endif

            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                @foreach([
                    ['Total Proyek', $totalProjects, 'text-white'],
                    ['Menunggu ACC', $pendingProjects, 'text-amber-300'],
                    ['Menunggu Bayar', $waitingPaymentProjects, 'text-sky-300'],
                    ['Aktif', $approvedProjects, 'text-emerald-300'],
                    ['Pembayaran Masuk', 'Rp'.number_format($paidRevenue, 0, ',', '.'), 'text-white'],
                ] as $stat)
                    <article class="rounded-3xl border border-white/10 bg-white/[0.07] p-5 shadow-xl shadow-black/10 backdrop-blur">
                        <p class="text-sm font-semibold text-stone-400">{{ $stat[0] }}</p>
                        <p class="mt-3 break-words text-3xl font-black {{ $stat[2] }}">{{ $stat[1] }}</p>
                    </article>
                @endforeach
            </section>

            <section class="mt-8 overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 shadow-2xl shadow-black/20">
                <div class="flex flex-col gap-3 border-b border-white/10 p-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-xl font-black text-white">Proyek Terbaru</h3>
                        <p class="mt-1 text-sm text-stone-400">Daftar aktivitas proyek yang terakhir masuk.</p>
                    </div>
                    <a href="{{ route('projects.index') }}" class="text-sm font-black text-amber-300 hover:text-amber-200">Lihat semua</a>
                </div>

                <div class="grid gap-4 p-4 sm:p-6 lg:grid-cols-2">
                    @forelse($projects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="group rounded-3xl border border-white/10 bg-white/[0.04] p-5 transition hover:-translate-y-1 hover:border-amber-300/50 hover:bg-white/[0.07]">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.24em] text-stone-500">{{ $project->project_code }}</p>
                                    <h4 class="mt-2 text-xl font-black text-white group-hover:text-amber-100">{{ $project->title }}</h4>
                                    <p class="mt-2 text-sm text-stone-400">{{ $project->construction_type }} - {{ $project->location }}</p>
                                </div>
                                <span class="w-fit rounded-full px-3 py-1 text-xs font-black capitalize {{ $project->status === 'approved' ? 'bg-emerald-400/15 text-emerald-300' : ($project->status === 'waiting_payment' ? 'bg-sky-400/15 text-sky-300' : ($project->status === 'rejected' ? 'bg-red-400/15 text-red-300' : 'bg-amber-400/15 text-amber-300')) }}">
                                    {{ str_replace('_', ' ', $project->status) }}
                                </span>
                            </div>
                            <p class="mt-5 text-lg font-black text-white">Rp{{ number_format($project->budget, 0, ',', '.') }}</p>
                        </a>
                    @empty
                        <div class="rounded-3xl border border-dashed border-white/20 p-10 text-center text-stone-400 lg:col-span-2">
                            Belum ada proyek. Mulai dengan mengajukan proyek pertama.
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
