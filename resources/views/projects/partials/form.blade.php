<div>
    <x-input-label for="title" value="Nama Proyek" />
    <x-text-input id="title" name="title" class="mt-1 block w-full" value="{{ old('title', $project->title ?? '') }}" required />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>
<div class="grid gap-5 sm:grid-cols-2">
    <div><x-input-label for="construction_type" value="Jenis Konstruksi" /><x-text-input id="construction_type" name="construction_type" class="mt-1 block w-full" value="{{ old('construction_type', $project->construction_type ?? '') }}" required /><x-input-error :messages="$errors->get('construction_type')" class="mt-2" /></div>
    <div><x-input-label for="location" value="Lokasi" /><x-text-input id="location" name="location" class="mt-1 block w-full" value="{{ old('location', $project->location ?? '') }}" required /><x-input-error :messages="$errors->get('location')" class="mt-2" /></div>
</div>
<div class="grid gap-5 sm:grid-cols-2">
    <div><x-input-label for="budget" value="Budget" /><x-text-input id="budget" type="number" name="budget" class="mt-1 block w-full" value="{{ old('budget', $project->budget ?? '') }}" min="1000000" required /><x-input-error :messages="$errors->get('budget')" class="mt-2" /></div>
    <div><x-input-label for="start_date" value="Tanggal Mulai" /><x-text-input id="start_date" type="date" name="start_date" class="mt-1 block w-full" value="{{ old('start_date', isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : '') }}" /><x-input-error :messages="$errors->get('start_date')" class="mt-2" /></div>
</div>
<div>
    <x-input-label for="description" value="Deskripsi Kebutuhan" />
    <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('description', $project->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>
