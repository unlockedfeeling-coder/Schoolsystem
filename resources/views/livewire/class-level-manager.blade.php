<div class="bg-white p-6 rounded shadow max-w-2xl">
    <h2 class="text-2xl font-bold mb-4">Manage Class Levels</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="mb-6">
        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Name</label>
            <input type="text" wire:model="name" class="border p-2 w-full rounded">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Slug (e.g., grade-1)</label>
            <input type="text" wire:model="slug" class="border p-2 w-full rounded">
            @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Save Level
        </button>
    </form>

    <h3 class="font-bold mb-2 text-lg border-b pb-2">Existing Levels:</h3>
    <ul class="border rounded">
        @forelse($levels as $level)
            <li class="border-b p-3 last:border-0 flex justify-between">
                <span>{{ $level->name }}</span>
                <span class="text-gray-500 text-sm">{{ $level->slug }}</span>
            </li>
        @empty
            <li class="p-3 text-gray-500">No levels found.</li>
        @endforelse
    </ul>
</div>