<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold text-gray-900 dark:text-white">Pembayaran Proyek</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('payments.store', $project) }}" class="space-y-5 rounded-3xl bg-white p-6 shadow dark:bg-gray-800">
            @csrf
            <div class="rounded-2xl bg-gray-50 p-4 dark:bg-gray-900"><p class="font-black dark:text-white">{{ $project->title }}</p><p class="text-sm text-gray-500">Sisa tagihan Rp{{ number_format($project->remainingAmount(), 0, ',', '.') }}</p></div>
            <div><x-input-label for="method" value="Metode" /><select name="method" id="method" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"><option value="qris">QRIS</option><option value="cash">Cash</option><option value="debit">Debit</option><option value="credit">Kredit</option><option value="digital">Digital Wallet</option><option value="bank_transfer">Bank Transfer</option></select><x-input-error :messages="$errors->get('method')" class="mt-2" /></div>
            <div><x-input-label for="amount" value="Nominal" /><x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" max="{{ $project->remainingAmount() }}" min="10000" required /><x-input-error :messages="$errors->get('amount')" class="mt-2" /></div>
            <div><x-input-label for="reference" value="Referensi Opsional" /><x-text-input id="reference" name="reference" class="mt-1 block w-full" /><x-input-error :messages="$errors->get('reference')" class="mt-2" /></div>
            <button class="w-full rounded-xl bg-amber-500 px-5 py-3 font-black text-gray-950">Buat Invoice</button>
        </form>
    </div></div>
</x-app-layout>
