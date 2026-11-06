<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Mark Attendance for {{ $class_name }}</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 font-bold">{{ session('message') }}</div>
    @endif

    @if($class_name === 'No Class Assigned')
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
            You are not assigned to any class. Please contact the Admin.
        </div>
    @else
        <div class="flex justify-between items-center mb-6 bg-gray-50 p-4 rounded-lg">
            <label class="font-bold text-gray-700">Select Date:</label>
            <input type="date" wire:model.live="date" class="border border-gray-300 p-2 rounded-lg">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                        <th class="p-4">Student Name</th>
                        <th class="p-4 text-center">Present</th>
                        <th class="p-4 text-center">Absent</th>
                        <th class="p-4 text-center">Late</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($students as $index => $student)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-bold text-gray-800">{{ $student['name'] }}</td>
                            <td class="p-4 text-center">
                                <input type="radio" wire:model="students.{{ $index }}.status" value="Present" class="w-5 h-5 text-green-600 focus:ring-green-500">
                            </td>
                            <td class="p-4 text-center">
                                <input type="radio" wire:model="students.{{ $index }}.status" value="Absent" class="w-5 h-5 text-red-600 focus:ring-red-500">
                            </td>
                            <td class="p-4 text-center">
                                <input type="radio" wire:model="students.{{ $index }}.status" value="Late" class="w-5 h-5 text-yellow-600 focus:ring-yellow-500">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <button wire:click="saveAttendance" class="bg-emerald-600 text-white px-8 py-3 rounded-lg hover:bg-emerald-700 font-bold shadow-lg transition">
                <i class="fas fa-save mr-2"></i> Save Attendance
            </button>
        </div>
    @endif
</div>