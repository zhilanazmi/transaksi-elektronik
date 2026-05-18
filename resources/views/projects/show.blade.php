<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold text-gray-900 dark:text-white">Detail Proyek</h2></x-slot>
    <div class="py-8"><div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
        @if (session('status'))<div class="rounded-xl bg-emerald-100 p-4 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200 lg:col-span-3">{{ session('status') }}</div>@endif
        <section class="rounded-3xl bg-white p-6 shadow dark:bg-gray-800 lg:col-span-2">
            <p class="text-xs font-bold text-gray-500">{{ $project->project_code }}</p>
            <h2 class="mt-1 text-3xl font-black text-gray-950 dark:text-white">{{ $project->title }}</h2>
            <p class="mt-3 text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
            <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                <div><dt class="text-sm text-gray-500">Jenis</dt><dd class="font-bold dark:text-white">{{ $project->construction_type }}</dd></div>
                <div><dt class="text-sm text-gray-500">Lokasi</dt><dd class="font-bold dark:text-white">{{ $project->location }}</dd></div>
                <div><dt class="text-sm text-gray-500">Budget</dt><dd class="font-bold dark:text-white">Rp{{ number_format($project->budget, 0, ',', '.') }}</dd></div>
                <div><dt class="text-sm text-gray-500">Sisa Tagihan</dt><dd class="font-bold dark:text-white">Rp{{ number_format($project->remainingAmount(), 0, ',', '.') }}</dd></div>
            </dl>
            @if($project->contract)
                <div class="mt-6 rounded-2xl border border-amber-300/40 bg-amber-50 p-5 dark:bg-amber-900/10">
                    <p class="text-sm font-bold text-amber-700 dark:text-amber-300">Kontrak {{ $project->contract->contract_number }}</p>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $project->contract->content }}</p>
                </div>
            @endif
        </section>
        <aside class="space-y-5">
            <div class="rounded-3xl bg-white p-6 shadow dark:bg-gray-800"><p class="text-sm text-gray-500">Status</p><p class="mt-2 text-2xl font-black capitalize text-amber-600">{{ $project->status }}</p>@if($project->admin_notes)<p class="mt-3 text-sm text-gray-500">{{ $project->admin_notes }}</p>@endif</div>
            @if($project->status === 'approved' && $project->user_id === auth()->id())<a href="{{ route('payments.create', $project) }}" class="block rounded-2xl bg-amber-500 px-5 py-4 text-center font-black text-gray-950">Buat Pembayaran</a>@endif
            @if($project->status === 'pending' && $project->user_id === auth()->id())<a href="{{ route('projects.edit', $project) }}" class="block rounded-2xl bg-gray-900 px-5 py-4 text-center font-black text-white dark:bg-gray-700">Edit Pengajuan</a>@endif
        </aside>
        <section class="rounded-3xl bg-white p-6 shadow dark:bg-gray-800 lg:col-span-3">
            <h3 class="mb-4 text-lg font-black text-gray-950 dark:text-white">Riwayat Pembayaran</h3>
            <div class="grid gap-3">
                @forelse($project->payments as $payment)
                    <div class="rounded-2xl border border-gray-100 p-4 dark:border-gray-700"><div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"><div><p class="font-bold dark:text-white">{{ $payment->invoice_number }}</p><p class="text-sm text-gray-500 uppercase">{{ $payment->method }} - {{ $payment->status }}</p></div><p class="font-black dark:text-white">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p></div>@if($payment->method === 'qris')<p class="mt-2 text-sm text-gray-500">QRIS: letakkan gambar di <code>public/images/qris.png</code></p>@endif</div>
                @empty
                    <p class="text-gray-500">Belum ada pembayaran.</p>
                @endforelse
            </div>
        </section>
    </div></div>
</x-app-layout>
