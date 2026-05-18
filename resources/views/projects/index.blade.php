<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold text-gray-900 dark:text-white">Proyek Saya</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if (session('status'))<div class="mb-4 rounded-xl bg-emerald-100 p-4 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">{{ session('status') }}</div>@endif
        <div class="mb-5 flex justify-end"><a class="rounded-xl bg-amber-500 px-4 py-2 font-bold text-gray-950" href="{{ route('projects.create') }}">Ajukan Proyek</a></div>
        <div class="overflow-hidden rounded-2xl bg-white shadow dark:bg-gray-800">
            @forelse($projects as $project)
                <a href="{{ route('projects.show', $project) }}" class="block border-b border-gray-100 p-5 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700/40">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div><p class="text-xs font-bold text-gray-500">{{ $project->project_code }}</p><h3 class="font-black text-gray-900 dark:text-white">{{ $project->title }}</h3><p class="text-sm text-gray-500">{{ $project->construction_type }} - {{ $project->location }}</p></div>
                        <div class="text-left sm:text-right"><p class="font-bold text-gray-900 dark:text-white">Rp{{ number_format($project->budget, 0, ',', '.') }}</p><p class="text-sm capitalize text-amber-600">{{ $project->status }}</p></div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-gray-500">Belum ada pengajuan proyek.</div>
            @endforelse
        </div>
        <div class="mt-5">{{ $projects->links() }}</div>
    </div></div>
</x-app-layout>
