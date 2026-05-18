<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold text-gray-900 dark:text-white">Approval Proyek</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if (session('status'))<div class="mb-4 rounded-xl bg-emerald-100 p-4 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">{{ session('status') }}</div>@endif
        <div class="grid gap-4">
            @foreach($projects as $project)
                <div class="rounded-3xl bg-white p-5 shadow dark:bg-gray-800">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div><p class="text-xs font-bold text-gray-500">{{ $project->project_code }} - {{ $project->customer->name }}</p><h3 class="text-xl font-black dark:text-white">{{ $project->title }}</h3><p class="mt-2 text-sm text-gray-500">{{ $project->description }}</p><p class="mt-3 font-bold dark:text-white">Rp{{ number_format($project->budget, 0, ',', '.') }} - <span class="capitalize text-amber-600">{{ $project->status }}</span></p></div>
                        <div class="min-w-72 space-y-3">
                            @if($project->status === 'pending')
                                <form method="POST" action="{{ route('admin.projects.approve', $project) }}" class="space-y-2">@csrf @method('PATCH')<input name="admin_notes" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" placeholder="Catatan approval"><button class="w-full rounded-xl bg-emerald-500 px-4 py-2 font-black text-white">Approve + Generate Contract</button></form>
                                <form method="POST" action="{{ route('admin.projects.reject', $project) }}" class="space-y-2">@csrf @method('PATCH')<input name="admin_notes" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" placeholder="Alasan reject"><button class="w-full rounded-xl bg-red-500 px-4 py-2 font-black text-white">Reject</button></form>
                            @else
                                <a href="{{ route('projects.show', $project) }}" class="block rounded-xl bg-gray-900 px-4 py-2 text-center font-bold text-white dark:bg-gray-700">Lihat Detail</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5">{{ $projects->links() }}</div>
    </div></div>
</x-app-layout>
