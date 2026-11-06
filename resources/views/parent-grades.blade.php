@extends('layouts.parent-app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Academic Grades & Performance Analysis</h2>

    @if($child)
        <div class="bg-purple-50 border-l-4 border-purple-500 text-purple-700 p-4 rounded mb-6">
            <strong>Student:</strong> {{ $child->first_name }} {{ $child->last_name }} ({{ $child->admission_number }})
        </div>

        @if($exams->count() > 0)
            {{-- STRENGTHS & WEAKNESSES ANALYSIS --}}
            @php
                $subjectScores = [];
                foreach($exams as $exam) {
                    $subjectScores[$exam->subject->name] = $exam->total_score ?? $exam->marks;
                }
                arsort($subjectScores);
                $strongest = array_key_first($subjectScores);
                $weakest = array_key_last($subjectScores);
                $strongestScore = $subjectScores[$strongest];
                $weakestScore = $subjectScores[$weakest];
                $average = array_sum($subjectScores) / count($subjectScores);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-green-50 border border-green-200 p-4 rounded-lg">
                    <h4 class="font-bold text-green-800 mb-2"><i class="fas fa-star mr-2"></i>Strongest Subject</h4>
                    <p class="text-lg font-bold text-green-900">{{ $strongest }}</p>
                    <p class="text-sm text-green-700">Score: {{ $strongestScore }}/100</p>
                </div>
                <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                    <h4 class="font-bold text-red-800 mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Needs Improvement</h4>
                    <p class="text-lg font-bold text-red-900">{{ $weakest }}</p>
                    <p class="text-sm text-red-700">Score: {{ $weakestScore }}/100</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                    <h4 class="font-bold text-blue-800 mb-2"><i class="fas fa-chart-line mr-2"></i>Overall Average</h4>
                    <p class="text-lg font-bold text-blue-900">{{ number_format($average, 1) }}%</p>
                    <p class="text-sm text-blue-700">
                        @if($average >= 80) Excellent Performance!
                        @elseif($average >= 70) Very Good Performance
                        @elseif($average >= 60) Good Performance
                        @elseif($average >= 50) Fair Performance
                        @else Needs Support
                        @endif
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                            <th class="p-4 rounded-tl-lg">Subject</th>
                            <th class="p-4">Class Score</th>
                            <th class="p-4">Exam Score</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Grade</th>
                            <th class="p-4">Position in Subject</th>
                            <th class="p-4 rounded-tr-lg">Overall Position</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            function getGradeParent($marks) {
                                if ($marks >= 80) return 'A';
                                if ($marks >= 70) return 'B';
                                if ($marks >= 60) return 'C';
                                if ($marks >= 50) return 'D';
                                if ($marks >= 40) return 'E';
                                return 'F';
                            }
                        @endphp
                        @foreach($exams as $exam)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-gray-800">{{ $exam->subject->name }}</td>
                                <td class="p-4 text-gray-600">{{ $exam->class_score ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $exam->exam_score ?? '-' }}</td>
                                <td class="p-4 font-bold text-blue-600">{{ $exam->total_score ?? $exam->marks }}</td>
                                <td class="p-4">
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">{{ getGradeParent($exam->total_score ?? $exam->marks) }}</span>
                                </td>
                                <td class="p-4">
                                    @if($exam->subject_position)
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold border border-yellow-300">
                                            {{ $exam->subject_position }}<sup>{{ $exam->subject_position == 1 ? 'st' : ($exam->subject_position == 2 ? 'nd' : ($exam->subject_position == 3 ? 'rd' : 'th')) }}</sup>
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($exam->position)
                                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-bold border border-purple-300">
                                            {{ $exam->position }}<sup>{{ $exam->position == 1 ? 'st' : ($exam->position == 2 ? 'nd' : ($exam->position == 3 ? 'rd' : 'th')) }}</sup>
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-10">No grades have been posted for this student yet.</p>
        @endif
    @else
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
            No child is currently linked to your account.
        </div>
    @endif
</div>
@endsection