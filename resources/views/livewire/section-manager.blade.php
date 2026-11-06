<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Manage Sections</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <!-- Add / Edit Form -->
    <form wire:submit.prevent="{{ $editing_id ? 'update' : 'save' }}" class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-50 p-6 rounded-lg border border-gray-200">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Section Name</label>
            <input type="text" wire:model="name" placeholder="e.g. A, B, Science" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Class Level</label>
            <select wire:model="class_level_id" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Class</option>
                @foreach($classLevels as $level) <option value="{{ $level->id }}">{{ $level->name }}</option> @endforeach
            </select>
            @error('class_level_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Capacity</label>
            <input type="number" wire:model="capacity" placeholder="e.g. 40" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('capacity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="{{ $editing_id ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700' }} text-white px-6 py-2.5 rounded-lg font-semibold shadow-md transition w-full">
                <i class="fas {{ $editing_id ? 'fa-save' : 'fa-plus' }} mr-2"></i> {{ $editing_id ? 'Update Section' : 'Add Section' }}
            </button>
            @if($editing_id)
                <button type="button" wire:click="cancelEdit" class="bg-gray-300 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-times"></i>
                </button>
            @endif
        </div>
    </form>

    <!-- Sections Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <th class="p-4 rounded-tl-lg">Section Name</th>
                    <th class="p-4">Assigned Class</th>
                    <th class="p-4">Capacity</th>
                    <th class="p-4 rounded-tr-lg">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sections as $section)
                    <tr class="hover:bg-gray-50 transition {{ $editing_id === $section->id ? 'bg-yellow-50' : '' }}">
                        <td class="p-4 font-bold text-gray-800">{{ $section->name }}</td>
                        <td class="p-4"><span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">{{ $section->classLevel->name ?? 'No Class' }}</span></td>
                        <td class="p-4 text-gray-600">{{ $section->capacity }} Students</td>
                        <td class="p-4 flex gap-3">
                            <button wire:click="edit({{ $section->id }})" class="text-yellow-600 hover:text-yellow-800 font-semibold text-sm">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <button wire:click="delete({{ $section->id }})" wire:confirm="Are you sure you want to delete this section?" class="text-red-500 hover:text-red-700 font-semibold text-sm">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-8 text-center text-gray-400">No sections created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>