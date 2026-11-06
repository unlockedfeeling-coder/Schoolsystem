<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Manage Teachers</h2>

    @if (session()->has('success_message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 font-bold whitespace-pre-line">
            {{ session('success_message') }}
        </div>
    @endif

    <!-- Registration Form -->
    <form wire:submit.prevent="save" class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-6 rounded-lg border border-gray-200">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">First Name</label>
            <input type="text" wire:model="first_name" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Last Name</label>
            <input type="text" wire:model="last_name" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        
        <!-- NEW: EMAIL FIELD FOR LOGIN -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Login Email</label>
            <input type="email" wire:model="email" placeholder="teacher@school.com" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Phone Number</label>
            <input type="text" wire:model="phone" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Subject</label>
            <select wire:model="subject_id" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Subject</option>
                @foreach($subjects as $subject) <option value="{{ $subject->id }}">{{ $subject->name }}</option> @endforeach
            </select>
            @error('subject_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Assigned Class</label>
            <select wire:model="class_level_id" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Class</option>
                @foreach($classes as $class) <option value="{{ $class->id }}">{{ $class->name }}</option> @endforeach
            </select>
            @error('class_level_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="md:col-span-2 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-semibold shadow-md transition">
                <i class="fas fa-plus mr-2"></i> Register Teacher
            </button>
        </div>
    </form>

    <!-- Search -->
    <div class="bg-gray-100 p-4 rounded-lg mb-4 flex items-center justify-between border border-gray-200">
        <h3 class="font-bold text-lg text-gray-800">Registered Teachers</h3>
        <div class="relative w-72">
            <input type="text" wire:model.live="search" placeholder="Search by name..." 
                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full bg-white">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <th class="p-4 rounded-tl-lg">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Subject</th>
                    <th class="p-4">Class</th>
                    <th class="p-4 rounded-tr-lg">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($teachers as $teacher)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold text-gray-800">{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                        <td class="p-4 text-gray-600">{{ $teacher->email }}</td>
                        <td class="p-4"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $teacher->subject->name ?? 'N/A' }}</span></td>
                        <td class="p-4"><span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">{{ $teacher->classLevel->name ?? 'N/A' }}</span></td>
                        <td class="p-4">
                            <button wire:click="delete({{ $teacher->id }})" wire:confirm="Are you sure?" class="text-red-500 hover:text-red-700 font-bold text-sm">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-400">No teachers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>