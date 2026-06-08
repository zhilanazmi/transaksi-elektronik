<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Admin Panel</p>
            <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">Pengajuan Mitra</h2>
            <p class="mt-1 text-sm text-stone-400">Review dan kelola pengajuan kemitraan baru.</p>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm font-semibold text-emerald-200">{{ session('success') }}</div>
            @endif

            <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 shadow-2xl shadow-black/20">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="p-5 text-xs font-black uppercase tracking-wider text-stone-500">Mitra</th>
                            <th class="p-5 text-xs font-black uppercase tracking-wider text-stone-500">User</th>
                            <th class="p-5 text-xs font-black uppercase tracking-wider text-stone-500">Jenis</th>
                            <th class="p-5 text-xs font-black uppercase tracking-wider text-stone-500">Status</th>
                            <th class="p-5 text-xs font-black uppercase tracking-wider text-stone-500 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                            <tr class="border-b border-white/10 last:border-b-0 hover:bg-white/[0.02] transition">
                                <td class="p-5">
                                    <p class="font-bold text-white">{{ $application->nama_mitra }}</p>
                                    <p class="text-xs text-stone-500">{{ $application->produk_mitra }}</p>
                                </td>
                                <td class="p-5 text-sm text-stone-300">
                                    {{ $application->user->name }}
                                </td>
                                <td class="p-5">
                                    <span class="text-xs font-bold px-2 py-1 rounded bg-stone-800 text-stone-300 uppercase tracking-tighter">{{ $application->jenis_mitra }}</span>
                                </td>
                                <td class="p-5">
                                    <span class="text-xs font-black capitalize {{ $application->status === 'approved' ? 'text-emerald-400' : ($application->status === 'rejected' ? 'text-red-400' : 'text-amber-400') }}">
                                        {{ $application->status }}
                                    </span>
                                </td>
                                <td class="p-5 text-right">
                                    <a href="{{ route('admin.mitra.show', $application) }}" class="text-amber-500 hover:text-amber-400 font-bold text-sm">Review</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-stone-500 font-bold">Tidak ada pengajuan pending.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $applications->links() }}</div>
        </div>
    </div>
</x-app-layout>
