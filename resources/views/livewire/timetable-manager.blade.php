<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Class Timetable</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-6 rounded-lg border border-gray-200">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Class Level</label>
            <select wire:model="class_level_id" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Class</option>
                @foreach($classLevels as $level) <option value="{{ $level->id }}">{{ $level->name }}</option> @endforeach
            </select>
            @error('class_level_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
            <label class="block text-gray-700 font-semibold mb-2">Teacher (Optional)</label>
            <select wire:model="teacher_id" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Teacher</option>
                @foreach($teachers as $teacher) <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Day of Week</label>
            <select wire:model="day_of_week" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Start Time</label>
            <input type="time" wire:model="start_time" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('start_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">End Time</label>
            <input type="time" wire:model="end_time" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('end_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="md:col-span-3 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-semibold shadow-md transition">
                <i class="fas fa-plus mr-2"></i> Add to Timetable
            </button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <th class="p-4 rounded-tl-lg">Class</th>
                    <th class="p-4">Day</th>
                    <th class="p-4">Time</th>
                    <th class="p-4">Subject</th>
                    <th class="p-4">Teacher</th>
                    <th class="p-4 rounded-tr-lg">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($timetables as $entry)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold text-gray-800">{{ $entry->classLevel->name }}</td>
                        <td class="p-4"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">{{ $entry->day_of_week }}</span></td>
                        <td class="p-4 text-gray-600">{{ $entry->start_time }} - {{ $entry->end_time }}</td>
                        <td class="p-4 text-gray-800">{{ $entry->subject->name }}</td>
                        <td class="p-4 text-gray-600 text-sm">{{ $entry->teacher ? $entry->teacher->first_name . ' ' . $entry->teacher->last_name : 'N/A' }}</td>
                        <td class="p-4">
                            <button wire:click="delete({{ $entry->id }})" wire:confirm="Delete this entry?" class="text-red-500 hover:text-red-700 text-sm font-semibold">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-8 text-center text-gray-400">No timetable entries yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>