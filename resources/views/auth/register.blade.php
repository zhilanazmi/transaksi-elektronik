<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-black uppercase tracking-[0.25em] text-amber-600">Akun Customer</p>
        <h1 class="mt-2 text-3xl font-black text-stone-950 dark:text-white">Ajukan pesanan laundry</h1>
        <p class="mt-2 text-sm text-stone-500 dark:text-stone-400">Buat akun untuk mengirim pengajuan, melihat kontrak, dan membuat pembayaran.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="mt-6 w-full justify-center py-3">Daftar</x-primary-button>

        <p class="mt-6 text-center text-sm text-stone-500 dark:text-stone-400">Sudah punya akun? <a href="{{ route('login') }}" class="font-black text-amber-600 hover:text-amber-500">Masuk</a></p>
    </form>
</x-guest-layout>
