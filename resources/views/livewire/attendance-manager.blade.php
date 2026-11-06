<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Mark Attendance</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Class Level</label>
            <select wire:model.live="class_level_id" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Class</option>
                @foreach($classLevels as $level) <option value="{{ $level->id }}">{{ $level->name }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Section</label>
            <select wire:model.live="section_id" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Section</option>
                @foreach($sections as $section) <option value="{{ $section->id }}">{{ $section->name }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Date</label>
            <input type="date" wire:model.live="date" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>

    <!-- Student List -->
    @if(count($students) > 0)
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                        <th class="p-4 rounded-tl-lg">Student Name</th>
                        <th class="p-4">Admission #</th>
                        <th class="p-4 rounded-tr-lg text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($students as $student)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-bold text-gray-800">{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td class="p-4 text-gray-600">{{ $student->admission_number }}</td>
                            <td class="p-4 text-center">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" wire:click="$set('attendance.{{ $student->id }}', 'Present')" 
                                        class="px-4 py-2 text-sm font-medium rounded-l-lg border {{ ($attendance[$student->id] ?? '') === 'Present' ? 'bg-green-500 text-white border-green-500' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                        Present
                                    </button>
                                    <button type="button" wire:click="$set('attendance.{{ $student->id }}', 'Absent')" 
                                        class="px-4 py-2 text-sm font-medium border-t border-b {{ ($attendance[$student->id] ?? '') === 'Absent' ? 'bg-red-500 text-white border-red-500' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                        Absent
                                    </button>
                                    <button type="button" wire:click="$set('attendance.{{ $student->id }}', 'Late')" 
                                        class="px-4 py-2 text-sm font-medium rounded-r-lg border {{ ($attendance[$student->id] ?? '') === 'Late' ? 'bg-yellow-500 text-white border-yellow-500' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                        Late
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end">
            <button wire:click="save" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-semibold shadow-md transition">
                <i class="fas fa-save mr-2"></i> Save Attendance
            </button>
        </div>
    @else
        <div class="text-center p-8 text-gray-500 bg-gray-50 rounded-lg">
            Please select a Class Level and Section to view students.
        </div>
    @endif
</div>