<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold text-gray-900 dark:text-white">POS Pembayaran</h2></x-slot>
    <div class="py-8"><div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
        @if (session('status'))<div class="rounded-xl bg-emerald-100 p-4 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200 lg:col-span-2">{{ session('status') }}</div>@endif
        <form method="POST" action="{{ route('pos.store') }}" class="space-y-5 rounded-3xl bg-white p-6 shadow dark:bg-gray-800">
            @csrf
            <h3 class="text-lg font-black dark:text-white">Transaksi Baru</h3>
            <div><x-input-label for="project_id" value="Proyek" /><select id="project_id" name="project_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">@foreach($projects as $project)<option value="{{ $project->id }}">{{ $project->project_code }} - {{ $project->customer->name }} - sisa Rp{{ number_format($project->remainingAmount(), 0, ',', '.') }}</option>@endforeach</select><x-input-error :messages="$errors->get('project_id')" class="mt-2" /></div>
            <div class="grid gap-4 sm:grid-cols-2"><div><x-input-label for="method" value="Metode" /><select id="method" name="method" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"><option value="cash">Cash</option><option value="debit">Debit</option><option value="credit">Kredit</option><option value="qris">QRIS</option><option value="digital">Digital</option><option value="bank_transfer">Transfer</option></select></div><div><x-input-label for="reference" value="Referensi" /><x-text-input id="reference" name="reference" class="mt-1 block w-full" /></div></div>
            <div class="grid gap-4 sm:grid-cols-2"><div><x-input-label for="amount" value="Nominal" /><x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" required /></div><div><x-input-label for="received_amount" value="Diterima" /><x-text-input id="received_amount" name="received_amount" type="number" class="mt-1 block w-full" required /></div></div>
            <button class="w-full rounded-xl bg-amber-500 px-5 py-3 font-black text-gray-950">Simpan Transaksi</button>
        </form>
        <section class="rounded-3xl bg-white p-6 shadow dark:bg-gray-800"><h3 class="mb-4 text-lg font-black dark:text-white">Transaksi Terbaru</h3><div class="space-y-3">@foreach($payments as $payment)<div class="rounded-2xl border border-gray-100 p-4 dark:border-gray-700"><p class="font-bold dark:text-white">{{ $payment->invoice_number }}</p><p class="text-sm text-gray-500">{{ $payment->project->title }} - {{ strtoupper($payment->method) }}</p><p class="mt-1 font-black dark:text-white">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p></div>@endforeach</div></section>
    </div></div>
</x-app-layout>
