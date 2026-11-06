<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Manage Subjects</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <!-- Add Subject Form -->
    <form wire:submit.prevent="save" class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-6 rounded-lg border border-gray-200">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Subject Name</label>
            <input type="text" wire:model="name" placeholder="e.g. Mathematics" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Subject Code</label>
            <input type="text" wire:model="code" placeholder="e.g. MATH101" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-semibold shadow-md transition w-full">
                <i class="fas fa-plus mr-2"></i> Add Subject
            </button>
        </div>
    </form>

    <!-- Subjects Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <th class="p-4 rounded-tl-lg">Subject Code</th>
                    <th class="p-4">Subject Name</th>
                    <th class="p-4 rounded-tr-lg">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($subjects as $subject)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold text-gray-800">{{ $subject->code }}</td>
                        <td class="p-4 text-gray-600">{{ $subject->name }}</td>
                        <td class="p-4">
                            <button wire:click="delete({{ $subject->id }})" wire:confirm="Are you sure you want to delete this subject?" class="text-red-500 hover:text-red-700 font-bold text-sm">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-8 text-center text-gray-400">No subjects added yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>