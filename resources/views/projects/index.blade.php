<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Order Center</p>
                <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">Pesanan Saya</h2>
                <p class="mt-1 text-sm text-stone-400">Kelola pengajuan, status validasi, dan pembayaran pesanan laundry.</p>
            </div>
            <a class="inline-flex justify-center rounded-2xl bg-amber-500 px-5 py-3 text-sm font-black text-stone-950 transition hover:-translate-y-0.5 hover:bg-amber-400" href="{{ route('projects.create') }}">
                Ajukan Pesanan
            </a>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm font-semibold text-emerald-200">{{ session('status') }}</div>
            @endif

            <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 shadow-2xl shadow-black/20">
                @forelse($projects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="block border-b border-white/10 p-5 transition last:border-b-0 hover:bg-white/[0.05] sm:p-6">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div class="min-w-0">
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-stone-500">{{ $project->project_code }}</p>
                                <h3 class="mt-2 truncate text-xl font-black text-white">{{ $project->title }}</h3>
                                <p class="mt-2 text-sm text-stone-400">{{ $project->construction_type }} - {{ number_format((float) ($project->laundry_weight ?? 0), 1, ',', '.') }} kg</p>
                            </div>
                            <div class="flex flex-col gap-2 md:items-end">
                                <p class="text-lg font-black text-white">Rp{{ number_format($project->budget, 0, ',', '.') }}</p>
                                <span class="w-fit rounded-full px-3 py-1 text-xs font-black capitalize {{ $project->status === 'approved' ? 'bg-emerald-400/15 text-emerald-300' : ($project->status === 'waiting_payment' ? 'bg-sky-400/15 text-sky-300' : ($project->status === 'rejected' ? 'bg-red-400/15 text-red-300' : 'bg-amber-400/15 text-amber-300')) }}">
                                    {{ str_replace('_', ' ', $project->status) }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-10 text-center">
                        <p class="text-lg font-black text-white">Belum ada pengajuan pesanan.</p>
                        <p class="mt-2 text-sm text-stone-400">Ajukan pesanan laundry pertama untuk memulai proses kontrak dan pembayaran.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">{{ $projects->links() }}</div>
        </div>
    </div>
</x-app-layout>
