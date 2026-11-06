<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Enter Grades for {{ $class_name }}</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 font-bold">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 font-bold">{{ session('error') }}</div>
    @endif

    @if($class_name === 'No Class Assigned')
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
            You are not assigned to any class. Please contact the Admin.
        </div>
    @else
        <div class="flex justify-between items-center mb-6 bg-gray-50 p-4 rounded-lg">
            <label class="font-bold text-gray-700">Select Subject:</label>
            <select wire:model.live="subject_id" class="border border-gray-300 p-2 rounded-lg bg-white w-64">
                <option value="">-- Choose a Subject --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        @if($subject_id)
            <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded mb-6 text-sm">
                <strong>Workflow:</strong> Enter the Total Score (out of 100) for each student. When you save, the system ranks students <strong>within this subject</strong>. 
                The "Calculate Overall Positions" button will only appear after you have entered marks for <strong>ALL</strong> subjects.
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                            <th class="p-4">Student Name</th>
                            <th class="p-4 text-center">Score (100)</th>
                            <th class="p-4 text-center">Rank in {{ \App\Models\Subject::find($subject_id)->name ?? 'Subject' }}</th>
                            <th class="p-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($students as $index => $student)
                            @php
                                $score = (int)($student['score'] ?: 0);
                                
                                $record = \App\Models\ExamResult::where('student_id', $student['id'])
                                    ->where('subject_id', $this->subject_id)->first();
                                $subjectPos = $record ? $record->subject_position : '-';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 font-bold text-gray-800">{{ $student['name'] }}</td>
                                <td class="p-4 text-center">
                                    <input type="number" wire:model="students.{{ $index }}.score" min="0" max="100" class="border border-gray-300 p-2 rounded w-24 text-center focus:ring-2 focus:ring-blue-500">
                                </td>
                                <td class="p-4 text-center">
                                    @if($subjectPos != '-')
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold border border-yellow-300">
                                            {{ $subjectPos }}<sup>{{ $subjectPos == 1 ? 'st' : ($subjectPos == 2 ? 'nd' : ($subjectPos == 3 ? 'rd' : 'th')) }}</sup>
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">Pending</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <a href="/students/{{ $student['id'] }}/report/download" target="_blank" class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700 transition">
                                        <i class="fas fa-file-pdf mr-1"></i> Print
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <button wire:click="saveGrades" class="bg-purple-600 text-white px-8 py-3 rounded-lg hover:bg-purple-700 font-bold shadow-lg transition">
                    <i class="fas fa-save mr-2"></i> Save Grades & Rank in Subject
                </button>

                @if($allSubjectsEntered)
                    <button wire:click="calculateOverallPositions" wire:confirm="This will calculate the final overall class positions based on ALL subjects. Continue?" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 font-bold shadow-lg transition animate-pulse">
                        <i class="fas fa-trophy mr-2"></i> Calculate Overall Positions
                    </button>
                @else
                    <div class="bg-orange-100 text-orange-800 px-6 py-3 rounded-lg border border-orange-300 font-semibold text-sm">
                        <i class="fas fa-clock mr-2"></i> Waiting for other subjects to be entered...
                    </div>
                @endif
            </div>
        @else
            <p class="text-center text-gray-500 py-10">Please select a subject above to enter grades.</p>
        @endif
    @endif
</div>