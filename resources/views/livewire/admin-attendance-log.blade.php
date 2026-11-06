<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Class Attendance Log</h2>

    <!-- Class Filter Dropdown -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200 flex items-center gap-4">
        <label class="font-bold text-gray-700">Filter by Class:</label>
        <select wire:model.live="selectedClassId" class="border border-gray-300 p-2.5 rounded-lg bg-white w-64 focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">-- Select a Class --</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Attendance Table -->
    @if($selectedClassId)
        @if($attendanceRecords->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                            <th class="p-4 rounded-tl-lg">Date</th>
                            <th class="p-4">Student Name</th>
                            <th class="p-4">Class</th>
                            <th class="p-4 rounded-tr-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($attendanceRecords as $record)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-600">{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</td>
                                <td class="p-4 font-bold text-gray-800">
                                    {{ $record->student->first_name ?? 'Unknown' }} {{ $record->student->last_name ?? '' }}
                                </td>
                                <td class="p-4 text-gray-600">
                                    {{ $record->student->classLevel->name ?? 'N/A' }}
                                </td>
                                <td class="p-4">
                                    @if($record->status === 'Present')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Present</span>
                                    @elseif($record->status === 'Absent')
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Absent</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">Late</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg text-center text-yellow-700">
                No attendance records found for this class yet.
            </div>
        @endif
    @else
        <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg text-center text-blue-700">
            <i class="fas fa-filter mb-2 text-2xl"></i>
            <p class="font-bold">Please select a class above to view its attendance log.</p>
        </div>
    @endif
</div>