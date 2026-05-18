<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-black uppercase tracking-[0.25em] text-amber-600">Masuk Sistem</p>
        <h1 class="mt-2 text-3xl font-black text-stone-950 dark:text-white">Selamat datang kembali</h1>
        <p class="mt-2 text-sm text-stone-500 dark:text-stone-400">Gunakan akun admin, staff, atau customer untuk melanjutkan transaksi proyek.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-stone-300 text-amber-600 shadow-sm focus:ring-amber-500 dark:border-white/10 dark:bg-stone-950" name="remember">
                <span class="ms-2 text-sm text-stone-600 dark:text-stone-400">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-stone-500 hover:text-amber-600 dark:text-stone-400" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        <x-primary-button class="mt-6 w-full justify-center py-3">Masuk</x-primary-button>

        <p class="mt-6 text-center text-sm text-stone-500 dark:text-stone-400">Belum punya akun? <a href="{{ route('register') }}" class="font-black text-amber-600 hover:text-amber-500">Daftar sebagai customer</a></p>
    </form>
</x-guest-layout>
