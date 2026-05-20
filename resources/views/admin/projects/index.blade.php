<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Admin</p>
            <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">Approval Pesanan</h2>
            <p class="mt-1 text-sm text-stone-400">Validasi pengajuan customer. Kontrak dibuat otomatis setelah pembayaran lunas.</p>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm font-semibold text-emerald-200">{{ session('status') }}</div>
            @endif

            <div class="grid gap-4">
                @forelse($projects as $project)
                    <article class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-5 shadow-xl shadow-black/20 sm:p-6">
                        <div class="grid gap-5 lg:grid-cols-[1fr_22rem] lg:items-start">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-stone-500">{{ $project->project_code }} - {{ $project->customer->name }}</p>
                                <h3 class="mt-2 text-xl font-black text-white">{{ $project->title }}</h3>
                                <p class="mt-3 text-sm leading-6 text-stone-400">{{ $project->description }}</p>
                                <div class="mt-4 flex flex-wrap gap-3">
                                    <span class="rounded-full bg-white/[0.06] px-3 py-1 text-sm font-bold text-white">{{ number_format((float) ($project->laundry_weight ?? 0), 1, ',', '.') }} kg</span>
                                    <span class="rounded-full bg-white/[0.06] px-3 py-1 text-sm font-bold text-white">Rp{{ number_format($project->budget, 0, ',', '.') }}</span>
                                    <span class="rounded-full px-3 py-1 text-sm font-black capitalize {{ $project->status === 'approved' ? 'bg-emerald-400/15 text-emerald-300' : ($project->status === 'waiting_payment' ? 'bg-sky-400/15 text-sky-300' : ($project->status === 'rejected' ? 'bg-red-400/15 text-red-300' : 'bg-amber-400/15 text-amber-300')) }}">{{ str_replace('_', ' ', $project->status) }}</span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @if($project->status === 'pending')
                                    <form method="POST" action="{{ route('admin.projects.approve', $project) }}" class="space-y-2 rounded-3xl border border-emerald-400/20 bg-emerald-400/5 p-4">
                                        @csrf
                                        @method('PATCH')
                                        <input name="admin_notes" class="w-full rounded-2xl border-white/10 bg-stone-950 text-white focus:border-emerald-500 focus:ring-emerald-500" placeholder="Catatan approval">
                                        <button class="w-full rounded-2xl bg-emerald-500 px-4 py-3 font-black text-white transition hover:bg-emerald-400">ACC Pesanan</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.projects.reject', $project) }}" class="space-y-2 rounded-3xl border border-red-400/20 bg-red-400/5 p-4">
                                        @csrf
                                        @method('PATCH')
                                        <input name="admin_notes" required class="w-full rounded-2xl border-white/10 bg-stone-950 text-white focus:border-red-500 focus:ring-red-500" placeholder="Alasan reject">
                                        <button class="w-full rounded-2xl bg-red-500 px-4 py-3 font-black text-white transition hover:bg-red-400">Reject</button>
                                    </form>
                                @else
                                    <a href="{{ route('projects.show', $project) }}" class="block rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-center font-black text-white transition hover:bg-white/10">Lihat Detail</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-[2rem] border border-dashed border-white/20 p-10 text-center text-stone-400">Belum ada pesanan untuk ditinjau.</div>
                @endforelse
            </div>

            <div class="mt-6">{{ $projects->links() }}</div>
        </div>
    </div>
</x-app-layout>
