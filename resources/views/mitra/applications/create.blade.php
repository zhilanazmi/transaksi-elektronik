<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.3em] text-amber-400">Form Mitra</p>
            <h2 class="mt-1 text-2xl font-black text-white sm:text-3xl">Ajukan Kemitraan Baru</h2>
            <p class="mt-1 text-sm text-stone-400">Lengkapi formulir di bawah ini untuk mengajukan kerjasama kemitraan.</p>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl shadow-black/20 sm:p-10">
                <form method="POST" action="{{ route('mitra.applications.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <x-input-label for="nama_mitra" value="Nama Mitra / Perusahaan" class="text-stone-300" />
                            <x-text-input id="nama_mitra" class="mt-1 block w-full bg-stone-950 border-white/10 text-white" type="text" name="nama_mitra" :value="old('nama_mitra')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_mitra')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="jenis_mitra" value="Jenis Mitra" class="text-stone-300" />
                            <select id="jenis_mitra" name="jenis_mitra" class="mt-1 block w-full rounded-xl border-white/10 bg-stone-950 text-white focus:border-amber-500 focus:ring-amber-500">
                                <option value="supplier" {{ old('jenis_mitra') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                <option value="distributor" {{ old('jenis_mitra') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_mitra')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="produk_mitra" value="Produk Mitra" class="text-stone-300" />
                            <x-text-input id="produk_mitra" class="mt-1 block w-full bg-stone-950 border-white/10 text-white" type="text" name="produk_mitra" :value="old('produk_mitra')" required />
                            <x-input-error :messages="$errors->get('produk_mitra')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="durasi_mitra" value="Durasi Kerjasama (Contoh: 1 Tahun)" class="text-stone-300" />
                            <x-text-input id="durasi_mitra" class="mt-1 block w-full bg-stone-950 border-white/10 text-white" type="text" name="durasi_mitra" :value="old('durasi_mitra')" required />
                            <x-input-error :messages="$errors->get('durasi_mitra')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kewajiban_mitra" value="Kewajiban Mitra" class="text-stone-300" />
                            <textarea id="kewajiban_mitra" name="kewajiban_mitra" rows="5" class="mt-1 block w-full rounded-xl border-white/10 bg-stone-950 text-white focus:border-amber-500 focus:ring-amber-500" required placeholder="1. Melakukan pengiriman rutin...&#10;2. Menjamin kualitas produk...">{{ old('kewajiban_mitra') }}</textarea>
                            <x-input-error :messages="$errors->get('kewajiban_mitra')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kewajiban_pemilik" value="Kewajiban Pemilik" class="text-stone-300" />
                            <textarea id="kewajiban_pemilik" name="kewajiban_pemilik" rows="5" class="mt-1 block w-full rounded-xl border-white/10 bg-stone-950 text-white focus:border-amber-500 focus:ring-amber-500" required placeholder="1. Melakukan pembayaran tepat waktu...&#10;2. Memberikan laporan stok...">{{ old('kewajiban_pemilik') }}</textarea>
                            <x-input-error :messages="$errors->get('kewajiban_pemilik')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-end gap-4">
                        <a href="{{ route('mitra.applications.index') }}" class="text-sm font-bold text-stone-400 hover:text-white">Batal</a>
                        <x-primary-button class="rounded-2xl bg-amber-500 px-8 py-3 font-black text-stone-950 hover:bg-amber-400">
                            Kirim Pengajuan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
