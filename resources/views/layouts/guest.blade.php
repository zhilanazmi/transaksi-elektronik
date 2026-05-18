<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ConstructPay') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-stone-900 antialiased">
        <div class="grid min-h-screen bg-stone-950 lg:grid-cols-[0.95fr_1.05fr]">
            <section class="relative hidden overflow-hidden p-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(245,158,11,.22),transparent_34%),linear-gradient(135deg,rgba(12,10,9,.98),rgba(41,37,36,.94))]"></div>
                <div class="absolute inset-0 opacity-[0.08]" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 42px 42px;"></div>
                <div class="relative z-10">
                    <a href="/" class="inline-flex"><x-application-logo /></a>
                </div>
                <div class="relative z-10 max-w-xl">
                    <p class="mb-4 inline-flex rounded-full border border-amber-300/20 bg-amber-300/10 px-4 py-2 text-sm font-bold text-amber-200">Portal proyek konstruksi</p>
                    <h1 class="text-5xl font-black leading-tight tracking-tight">Kelola proyek, kontrak, dan pembayaran dengan aman.</h1>
                    <p class="mt-5 text-lg leading-8 text-stone-300">Login untuk mengajukan proyek, mengelola approval, mencetak kontrak PDF, dan mencatat pembayaran lewat POS.</p>
                </div>
                <div class="relative z-10 grid grid-cols-3 gap-3">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4"><p class="text-2xl font-black">PDF</p><p class="text-xs text-stone-400">Kontrak</p></div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4"><p class="text-2xl font-black">QRIS</p><p class="text-xs text-stone-400">Payment</p></div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4"><p class="text-2xl font-black">POS</p><p class="text-xs text-stone-400">Staff</p></div>
                </div>
            </section>

            <section class="flex min-h-screen items-center justify-center bg-stone-100 px-5 py-10 dark:bg-stone-950 sm:px-8">
                <div class="w-full max-w-md">
                    <div class="mb-8 flex justify-center lg:hidden">
                        <a href="/"><x-application-logo /></a>
                    </div>
                    <div class="rounded-[2rem] border border-stone-200 bg-white p-6 shadow-2xl shadow-stone-950/10 dark:border-white/10 dark:bg-stone-900 sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>
