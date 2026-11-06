<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-2 text-gray-800">Register New Student</h2>
    
    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded mb-6 flex justify-between items-center">
        <div><strong>Registering for Session:</strong> {{ $activeSessionName }}</div>
        <span class="text-xs bg-blue-200 text-blue-800 px-2 py-1 rounded font-bold">Auto-Linked</span>
    </div>

    @if (session()->has('error_message'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6"><strong>Error:</strong> {{ session('error_message') }}</div>
    @endif
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">{{ session('message') }}</div>
    @endif

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
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Admission Number</label>
            <input type="text" wire:model="admission_number" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('admission_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Date of Birth</label>
            <input type="date" wire:model="date_of_birth" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Gender</label>
            <select wire:model="gender" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Class Level</label>
            <select wire:model.live="class_level_id" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Class</option>
                @foreach($classLevels as $level) <option value="{{ $level->id }}">{{ $level->name }}</option> @endforeach
            </select>
            @error('class_level_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Section</label>
            <select wire:model="section_id" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Section</option>
                @foreach($available_sections as $section) <option value="{{ $section->id }}">{{ $section->name }}</option> @endforeach
            </select>
            @error('section_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="md:col-span-2 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-semibold shadow-md transition">
                <i class="fas fa-plus mr-2"></i> Register Student
            </button>
        </div>
    </form>

    <!-- SEARCH BAR AND TABLE -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-lg text-gray-800">Registered Students</h3>
        <div class="relative w-64">
            <input type="text" wire:model.live="search" placeholder="Search name or admission..." 
                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <th class="p-4 rounded-tl-lg">Admission #</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Class</th>
                    <th class="p-4">Section</th>
                    <th class="p-4 rounded-tr-lg">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($students as $student)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-gray-600">{{ $student->admission_number }}</td>
                        <td class="p-4 font-bold text-gray-800">{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td class="p-4"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $student->classLevel->name ?? 'N/A' }}</span></td>
                        <td class="p-4"><span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">{{ $student->section->name ?? 'N/A' }}</span></td>
                        <td class="p-4">
                            <a href="/students/{{ $student->id }}" class="bg-blue-50 text-blue-600 px-3 py-1 rounded hover:bg-blue-100 transition text-sm font-medium">
                                <i class="fas fa-eye mr-1"></i> View Profile
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-400">No students found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>