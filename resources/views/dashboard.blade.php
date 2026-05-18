<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-500">ConstructPay</p>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Konstruksi</h2>
            </div>
            <a href="{{ route('projects.create') }}" class="rounded-full bg-amber-500 px-5 py-2 text-sm font-bold text-gray-950 shadow-lg shadow-amber-500/20 hover:bg-amber-400">Ajukan Proyek</a>
        </div>
    </x-slot>

    <div class="bg-gray-950 py-10 text-gray-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm text-emerald-200">{{ session('status') }}</div>
            @endif

            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur"><p class="text-sm text-gray-400">Total Proyek</p><p class="mt-3 text-3xl font-black">{{ $totalProjects }}</p></div>
                <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur"><p class="text-sm text-gray-400">Menunggu ACC</p><p class="mt-3 text-3xl font-black text-amber-300">{{ $pendingProjects }}</p></div>
                <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur"><p class="text-sm text-gray-400">Disetujui</p><p class="mt-3 text-3xl font-black text-emerald-300">{{ $approvedProjects }}</p></div>
                <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur"><p class="text-sm text-gray-400">Pembayaran Masuk</p><p class="mt-3 text-2xl font-black">Rp{{ number_format($paidRevenue, 0, ',', '.') }}</p></div>
            </div>

            <div class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.06] p-6">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-lg font-bold">Proyek Terbaru</h3>
                    <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-amber-300 hover:text-amber-200">Lihat semua</a>
                </div>
                <div class="grid gap-4 lg:grid-cols-2">
                    @forelse($projects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="rounded-2xl border border-white/10 bg-gray-900 p-5 transition hover:-translate-y-1 hover:border-amber-300/50">
                            <div class="flex items-start justify-between gap-4">
                                <div><p class="text-xs font-bold uppercase tracking-widest text-gray-500">{{ $project->project_code }}</p><h4 class="mt-1 text-xl font-black">{{ $project->title }}</h4></div>
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $project->status === 'approved' ? 'bg-emerald-400/15 text-emerald-300' : ($project->status === 'rejected' ? 'bg-red-400/15 text-red-300' : 'bg-amber-400/15 text-amber-300') }}">{{ ucfirst($project->status) }}</span>
                            </div>
                            <p class="mt-3 text-sm text-gray-400">{{ $project->construction_type }} - {{ $project->location }}</p>
                            <p class="mt-4 text-lg font-bold">Rp{{ number_format($project->budget, 0, ',', '.') }}</p>
                        </a>
                    @empty
                        <div class="rounded-2xl border border-dashed border-white/20 p-8 text-center text-gray-400 lg:col-span-2">Belum ada proyek.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
