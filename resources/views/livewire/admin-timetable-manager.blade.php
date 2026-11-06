<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Master Timetable Manager</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 font-bold">{{ session('message') }}</div>
    @endif

    <!-- Add Entry Form -->
    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
        <h3 class="font-bold text-lg mb-4 text-gray-700">Add New Lesson</h3>
        <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Day</label>
                <select wire:model="day" class="border p-2 w-full rounded">
                    <option value="">Select Day</option>
                    @foreach($days as $d) <option value="{{ $d }}">{{ $d }}</option> @endforeach
                </select>
                @error('day') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Start Time</label>
                <input type="time" wire:model="start_time" class="border p-2 w-full rounded">
                @error('start_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">End Time</label>
                <input type="time" wire:model="end_time" class="border p-2 w-full rounded">
                @error('end_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Room (Optional)</label>
                <input type="text" wire:model="room" placeholder="e.g. Room 5" class="border p-2 w-full rounded">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Subject</label>
                <select wire:model="subject_id" class="border p-2 w-full rounded">
                    <option value="">Select Subject</option>
                    @foreach($subjects as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach
                </select>
                @error('subject_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Class/Form</label>
                <select wire:model="class_level_id" class="border p-2 w-full rounded">
                    <option value="">Select Class</option>
                    @foreach($classes as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                </select>
                @error('class_level_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Teacher</label>
                <select wire:model="teacher_id" class="border p-2 w-full rounded">
                    <option value="">Select Teacher</option>
                    @foreach($teachers as $t)
                        <option value="{{ $t->id }}">{{ $t->first_name }} {{ $t->last_name }} ({{ $t->subject->name ?? 'No Subject' }})</option>
                    @endforeach
                </select>
                @error('teacher_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full font-bold hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> Add Lesson
                </button>
            </div>
        </form>
    </div>

    <!-- Filters -->
    <div class="flex gap-4 mb-4">
        <select wire:model.live="filterClassId" class="border p-2 rounded">
            <option value="">All Classes</option>
            @foreach($classes as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
        </select>
        <select wire:model.live="filterDay" class="border p-2 rounded">
            <option value="">All Days</option>
            @foreach($days as $d) <option value="{{ $d }}">{{ $d }}</option> @endforeach
        </select>
    </div>

    <!-- Entries Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <th class="p-3">Day</th>
                    <th class="p-3">Time</th>
                    <th class="p-3">Subject</th>
                    <th class="p-3">Class</th>
                    <th class="p-3">Teacher</th>
                    <th class="p-3">Room</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($entries as $entry)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 font-bold">{{ $entry->day }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($entry->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($entry->end_time)->format('g:i A') }}</td>
                        <td class="p-3">{{ $entry->subject->name ?? 'N/A' }}</td>
                        <td class="p-3"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $entry->classLevel->name ?? 'N/A' }}</span></td>
                        <td class="p-3">{{ $entry->teacher->first_name ?? 'N/A' }} {{ $entry->teacher->last_name ?? '' }}</td>
                        <td class="p-3 text-gray-600">{{ $entry->room ?: '-' }}</td>
                        <td class="p-3">
                            <button wire:click="delete({{ $entry->id }})" wire:confirm="Delete this lesson?" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-8 text-center text-gray-400">No timetable entries yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>