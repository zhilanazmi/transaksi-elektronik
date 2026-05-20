<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ConstructPay') }} - Transaksi Konstruksi Digital</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-950 font-sans text-stone-100 antialiased">
    <div class="min-h-screen">
        <header class="sticky top-0 z-30 border-b border-white/10 bg-stone-950/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="/" class="flex items-center gap-3" aria-label="ConstructPay home">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 text-base font-black text-stone-950">CP</span>
                    <span class="leading-tight">
                        <span class="block text-base font-black tracking-tight sm:text-lg">ConstructPay</span>
                        <span class="hidden text-xs font-semibold text-stone-400 sm:block">Transaksi konstruksi digital</span>
                    </span>
                </a>

                <nav class="flex items-center gap-2 text-sm font-bold">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-full bg-amber-500 px-4 py-2.5 text-stone-950 transition hover:bg-amber-400 sm:px-5">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden rounded-full px-4 py-2.5 text-stone-200 transition hover:bg-white/10 sm:inline-flex">Masuk</a>
                        <a href="{{ route('register') }}" class="rounded-full bg-amber-500 px-4 py-2.5 text-stone-950 transition hover:bg-amber-400 sm:px-5">Daftar</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main>
            <section class="relative overflow-hidden bg-stone-950">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(245,158,11,0.2),transparent_32%),radial-gradient(circle_at_bottom_right,rgba(120,113,108,0.22),transparent_28%)]"></div>
                <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-12 sm:px-6 sm:py-16 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:py-24">
                    <div class="relative z-10">
                        <p class="inline-flex rounded-full border border-amber-300/20 bg-amber-300/10 px-4 py-2 text-sm font-bold text-amber-200">
                            Platform proyek, kontrak, dan pembayaran
                        </p>
                        <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-6xl lg:leading-[1.02]">
                            Kelola transaksi proyek konstruksi dengan lebih rapi.
                        </h1>
                        <p class="mt-5 max-w-2xl text-base leading-7 text-stone-300 sm:text-lg sm:leading-8">
                            Customer bisa mengajukan proyek, admin memvalidasi, kontrak dibuat otomatis, lalu pembayaran dicatat melalui invoice atau POS.
                        </p>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            <a href="{{ auth()->check() ? route('projects.create') : route('register') }}" class="inline-flex justify-center rounded-2xl bg-amber-500 px-6 py-4 text-base font-black text-stone-950 transition hover:-translate-y-0.5 hover:bg-amber-400">
                                Ajukan Proyek
                            </a>
                            <a href="#alur" class="inline-flex justify-center rounded-2xl border border-white/15 bg-white/5 px-6 py-4 text-base font-black text-white transition hover:border-amber-300 hover:text-amber-200">
                                Lihat Alur
                            </a>
                        </div>
                    </div>

                    <div class="relative z-10 mx-auto w-full max-w-md lg:max-w-none">
                        <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/5 p-4 shadow-2xl shadow-black/30 sm:p-6">
                            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent"></div>
                            <div class="relative flex aspect-[4/3] items-center justify-center rounded-[1.5rem] bg-stone-900/80 p-6">
                                <img src="{{ asset('images/ijatawakal.jfif') }}" alt="Ilustrasi proyek konstruksi" class="h-full w-full object-contain drop-shadow-2xl" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="hidden h-full w-full items-center justify-center rounded-2xl border border-dashed border-amber-300/40 bg-amber-300/5 text-center text-sm font-bold leading-6 text-amber-100">
                                    Letakkan file PNG di<br>public/images/construction-hero.png
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="alur" class="bg-stone-900 py-14 sm:py-16">
                <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-2xl">
                        <p class="text-sm font-black uppercase tracking-[0.22em] text-amber-600">Alur Singkat</p>
                        <h2 class="mt-3 text-3xl font-black tracking-tight text-white sm:text-4xl">Empat langkah dari pengajuan sampai proyek aktif.</h2>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach([
                            ['1', 'Ajukan', 'Customer mengisi detail proyek dan budget.'],
                            ['2', 'Validasi', 'Admin meninjau lalu membuat kontrak.'],
                            ['3', 'Bayar', 'Invoice atau POS mencatat pembayaran.'],
                            ['4', 'Aktif', 'Proyek approved setelah pembayaran lunas.'],
                        ] as $step)
                            <article class="rounded-3xl border border-white/10 bg-white/5 p-5">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-500 text-sm font-black text-stone-950">{{ $step[0] }}</span>
                                <h3 class="mt-5 text-lg font-black text-white">{{ $step[1] }}</h3>
                                <p class="mt-2 text-sm leading-6 text-stone-300">{{ $step[2] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="bg-stone-950 py-14 sm:py-16">
                <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
                        <div>
                            <p class="text-sm font-black uppercase tracking-[0.22em] text-amber-600">Fitur Utama</p>
                            <h2 class="mt-3 text-3xl font-black tracking-tight text-white sm:text-4xl">Fokus pada kebutuhan transaksi.</h2>
                            <p class="mt-4 text-base leading-7 text-stone-300">Tanpa proses yang rumit, semua fitur diarahkan untuk membantu pencatatan proyek dan pembayaran.</p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            @foreach([
                                ['Kontrak otomatis', 'Dokumen dibuat setelah proyek di-ACC admin.'],
                                ['Pembayaran fleksibel', 'Mendukung cash, debit, kredit, QRIS, dan transfer.'],
                                ['POS staff', 'Staff dapat mencatat transaksi langsung di kasir.'],
                                ['Akses sesuai role', 'Customer, staff, dan admin punya batasan akses masing-masing.'],
                            ] as $feature)
                                <article class="rounded-3xl border border-white/10 bg-stone-900 p-5 shadow-sm shadow-black/20">
                                    <h3 class="text-lg font-black text-white">{{ $feature[0] }}</h3>
                                    <p class="mt-2 text-sm leading-6 text-stone-300">{{ $feature[1] }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-stone-800 bg-stone-950 py-8">
            <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 text-sm text-stone-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p class="font-semibold text-white">ConstructPay</p>
                <p class="text-stone-400">Transaksi elektronik untuk proyek konstruksi.</p>
            </div>
        </footer>
    </div>
</body>
</html>
