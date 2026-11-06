<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Enter Exam Marks</h2>

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
            <label class="block text-gray-700 font-semibold mb-2">Subject</label>
            <select wire:model.live="subject_id" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Subject</option>
                @foreach($subjects as $subject) <option value="{{ $subject->id }}">{{ $subject->name }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Exam Type</label>
            <select wire:model.live="exam_type" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Midterm">Midterm</option>
                <option value="Final">Final Exam</option>
                <option value="Quiz">Quiz</option>
            </select>
        </div>
    </div>

    <!-- Student Marks List -->
    @if(count($students) > 0)
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                        <th class="p-4 rounded-tl-lg">Student Name</th>
                        <th class="p-4">Admission #</th>
                        <th class="p-4 rounded-tr-lg text-center">Marks (Out of 100)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($students as $student)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-bold text-gray-800">{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td class="p-4 text-gray-600">{{ $student->admission_number }}</td>
                            <td class="p-4 text-center">
                                <input type="number" wire:model.live="marks.{{ $student->id }}" 
                                    class="border border-gray-300 p-2 w-24 rounded-lg text-center outline-none focus:ring-2 focus:ring-blue-500" 
                                    min="0" max="100" placeholder="0">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end">
            <button wire:click="save" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-semibold shadow-md transition">
                <i class="fas fa-save mr-2"></i> Save Marks
            </button>
        </div>
    @else
        <div class="text-center p-8 text-gray-500 bg-gray-50 rounded-lg">
            Please select a Class Level and Subject to view students.
        </div>
    @endif
</div>