<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Academic Sessions</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-6 rounded-lg border border-gray-200">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Session Name <span class="text-red-500">*</span></label>
            <input type="text" wire:model="name" placeholder="e.g. 2024-2025 1st Trimester" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('name') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Start Date <span class="text-red-500">*</span></label>
            <input type="date" wire:model="start_date" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('start_date') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">End Date <span class="text-red-500">*</span></label>
            <input type="date" wire:model="end_date" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('end_date') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
        </div>
        <div class="md:col-span-3 flex justify-end">
            <button type="submit" class="bg-purple-600 text-white px-6 py-2.5 rounded-lg hover:bg-purple-700 font-semibold shadow-md transition">
                <i class="fas fa-plus mr-2"></i> Add Session
            </button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <th class="p-4 rounded-tl-lg">Session Name</th>
                    <th class="p-4">Duration</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 rounded-tr-lg">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sessions as $session)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold text-gray-800">{{ $session->name }}</td>
                        <td class="p-4 text-gray-600 text-sm">{{ $session->start_date }} to {{ $session->end_date }}</td>
                        <td class="p-4">
                            @if($session->is_active)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold border border-green-200">ACTIVE</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Inactive</span>
                            @endif
                        </td>
                        <td class="p-4 flex gap-2">
                            @if(!$session->is_active)
                                <button wire:click="setActive({{ $session->id }})" wire:confirm="Make this the active school year?" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i> Set Active
                                </button>
                            @endif
                            <button wire:click="delete({{ $session->id }})" wire:confirm="Are you sure you want to delete this session?" class="text-red-500 hover:text-red-700 text-sm font-semibold">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-8 text-center text-gray-400">No sessions created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>