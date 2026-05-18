<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Point of Sale</p>
            <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">POS Pembayaran</h2>
            <p class="mt-1 text-sm text-stone-400">Catat pembayaran langsung dari customer di kasir.</p>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm font-semibold text-emerald-200 lg:col-span-2">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('pos.store') }}" class="space-y-5 rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20">
                @csrf
                <h3 class="text-xl font-black text-white">Transaksi Baru</h3>

                <div>
                    <x-input-label for="project_id" value="Proyek" />
                    <select id="project_id" name="project_id" class="mt-2 block w-full rounded-2xl border-white/10 bg-stone-950 text-stone-200 focus:border-amber-500 focus:ring-amber-500">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->project_code }} - {{ $project->customer->name }} - sisa Rp{{ number_format($project->remainingAmount(), 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="method" value="Metode" />
                        <select id="method" name="method" class="mt-2 block w-full rounded-2xl border-white/10 bg-stone-950 text-stone-200 focus:border-amber-500 focus:ring-amber-500">
                            <option value="cash">Cash</option>
                            <option value="debit">Debit</option>
                            <option value="credit">Kredit</option>
                            <option value="qris">QRIS</option>
                            <option value="digital">Digital</option>
                            <option value="bank_transfer">Transfer</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="reference" value="Referensi" />
                        <x-text-input id="reference" name="reference" class="mt-2 block w-full" />
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="amount" value="Nominal" />
                        <x-text-input id="amount" name="amount" type="number" class="mt-2 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="received_amount" value="Diterima" />
                        <x-text-input id="received_amount" name="received_amount" type="number" class="mt-2 block w-full" required />
                    </div>
                </div>

                <button class="w-full rounded-2xl bg-amber-500 px-5 py-4 font-black text-stone-950 transition hover:bg-amber-400">Simpan Transaksi</button>
            </form>

            <section class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20">
                <h3 class="text-xl font-black text-white">Transaksi Terbaru</h3>
                <div class="mt-5 space-y-3">
                    @forelse($payments as $payment)
                        <div class="rounded-3xl border border-white/10 bg-white/[0.04] p-4">
                            <p class="font-black text-white">{{ $payment->invoice_number }}</p>
                            <p class="mt-1 text-sm text-stone-400">{{ $payment->project->title }} - {{ strtoupper($payment->method) }}</p>
                            <p class="mt-2 text-lg font-black text-white">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="rounded-3xl border border-dashed border-white/20 p-8 text-center text-stone-400">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
