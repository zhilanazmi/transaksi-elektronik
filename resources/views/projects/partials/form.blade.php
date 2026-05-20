@php($servicePrices = $servicePrices ?? [])

<div x-data="{
    prices: @js($servicePrices),
    service: @js(old('construction_type', $project->construction_type ?? array_key_first($servicePrices))),
    weight: @js(old('laundry_weight', $project->laundry_weight ?? 1)),
    get total() {
        return Math.ceil((parseFloat(this.weight) || 0) * (this.prices[this.service] || 0));
    },
    format(value) {
        return new Intl.NumberFormat('id-ID').format(value || 0);
    }
}" class="space-y-5">
    <div class="rounded-3xl border border-amber-300/20 bg-amber-300/10 p-5">
        <p class="text-sm font-black uppercase tracking-[0.24em] text-amber-200">Pricelist Laundry</p>
        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            @foreach($servicePrices as $service => $price)
                <div class="rounded-2xl border border-white/10 bg-stone-950/50 p-4">
                    <p class="font-black text-white">{{ $service }}</p>
                    <p class="mt-1 text-sm text-stone-300">Rp{{ number_format($price, 0, ',', '.') }}/kg</p>
                </div>
            @endforeach
        </div>
    </div>

    <div>
        <x-input-label for="title" value="Nama Pesanan" />
        <x-text-input id="title" name="title" class="mt-1 block w-full" value="{{ old('title', $project->title ?? '') }}" required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <x-input-label for="construction_type" value="Jenis Layanan" />
            <select id="construction_type" name="construction_type" x-model="service" class="mt-1 block w-full rounded-2xl border-white/10 bg-stone-950 text-stone-200 focus:border-amber-500 focus:ring-amber-500" required>
                @foreach($servicePrices as $service => $price)
                    <option value="{{ $service }}">{{ $service }} - Rp{{ number_format($price, 0, ',', '.') }}/kg</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('construction_type')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="laundry_weight" value="Berat Cucian (kg)" />
            <x-text-input id="laundry_weight" type="number" step="0.1" min="1" max="100" name="laundry_weight" x-model="weight" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('laundry_weight')" class="mt-2" />
        </div>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <x-input-label for="location" value="Alamat Pickup/Antar" />
            <x-text-input id="location" name="location" class="mt-1 block w-full" value="{{ old('location', $project->location ?? '') }}" required />
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="start_date" value="Tanggal Pickup" />
            <x-text-input id="start_date" type="date" name="start_date" class="mt-1 block w-full" value="{{ old('start_date', isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : '') }}" />
            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
        </div>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/[0.04] p-5">
        <p class="text-sm font-semibold text-stone-400">Total tagihan otomatis</p>
        <p class="mt-2 text-3xl font-black text-white">Rp<span x-text="format(total)"></span></p>
        <p class="mt-2 text-sm text-stone-400">Dihitung dari berat cucian dikali harga layanan. Nominal final divalidasi ulang oleh server.</p>
    </div>

    <div>
        <x-input-label for="description" value="Detail Cucian" />
        <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-2xl border-white/10 bg-stone-950 text-stone-100 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description', $project->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
</div>
