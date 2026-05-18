<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Pengajuan</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-5 rounded-3xl bg-white p-6 shadow dark:bg-gray-800">
            @csrf @method('PUT')
            @include('projects.partials.form')
            <button class="w-full rounded-xl bg-amber-500 px-5 py-3 font-black text-gray-950 hover:bg-amber-400">Simpan Perubahan</button>
        </form>
    </div></div>
</x-app-layout>
