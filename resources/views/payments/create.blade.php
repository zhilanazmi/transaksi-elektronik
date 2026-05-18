<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Invoice</p>
            <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">Pembayaran Proyek</h2>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto grid max-w-5xl gap-6 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:px-8">
            <aside class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-xl shadow-black/20">
                <p class="text-xs font-black uppercase tracking-[0.24em] text-stone-500">{{ $project->project_code }}</p>
                <h3 class="mt-3 text-2xl font-black text-white">{{ $project->title }}</h3>
                <div class="mt-6 space-y-3 text-sm">
                    <div class="flex justify-between gap-4 rounded-2xl bg-white/[0.04] p-4">
                        <span class="text-stone-400">Status</span>
                        <span class="font-black capitalize text-amber-300">{{ str_replace('_', ' ', $project->status) }}</span>
                    </div>
                    <div class="flex justify-between gap-4 rounded-2xl bg-white/[0.04] p-4">
                        <span class="text-stone-400">Sisa tagihan</span>
                        <span class="font-black text-white">Rp{{ number_format($project->remainingAmount(), 0, ',', '.') }}</span>
                    </div>
                </div>
            </aside>

            <form method="POST" action="{{ route('payments.store', $project) }}" class="space-y-5 rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20">
                @csrf
                <div>
                    <x-input-label for="method" value="Metode Pembayaran" />
                    <select name="method" id="method" class="mt-2 block w-full rounded-2xl border-white/10 bg-stone-950 text-stone-200 focus:border-amber-500 focus:ring-amber-500">
                        <option value="qris">QRIS</option>
                        <option value="cash">Cash</option>
                        <option value="debit">Debit</option>
                        <option value="credit">Kredit</option>
                        <option value="digital">Digital Wallet</option>
                        <option value="bank_transfer">Bank Transfer</option>
                    </select>
                    <x-input-error :messages="$errors->get('method')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="amount" value="Nominal" />
                    <x-text-input id="amount" name="amount" type="number" class="mt-2 block w-full" max="{{ $project->remainingAmount() }}" min="10000" required />
                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="reference" value="Referensi Opsional" />
                    <x-text-input id="reference" name="reference" class="mt-2 block w-full" />
                    <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                </div>

                <button class="w-full rounded-2xl bg-amber-500 px-5 py-4 font-black text-stone-950 transition hover:bg-amber-400">Buat Invoice</button>
            </form>
        </div>
    </div>
</x-app-layout>
