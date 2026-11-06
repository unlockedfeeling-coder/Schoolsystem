@extends('layouts.student-app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">My Academic Grades</h2>

    @if($student)
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded mb-6">
            <strong>Welcome:</strong> {{ $student->first_name }} {{ $student->last_name }}
        </div>

        @if($exams->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                            <th class="p-4 rounded-tl-lg">Subject</th>
                            <th class="p-4">Score (100)</th>
                            <th class="p-4">Grade</th>
                            <th class="p-4 rounded-tr-lg">Remark</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            function getGradeStudent($marks) {
                                if ($marks >= 80) return ['A', 'Excellent'];
                                if ($marks >= 70) return ['B', 'Very Good'];
                                if ($marks >= 60) return ['C', 'Good'];
                                if ($marks >= 50) return ['D', 'Credit'];
                                if ($marks >= 40) return ['E', 'Pass'];
                                return ['F', 'Fail'];
                            }
                        @endphp
                        @foreach($exams as $exam)
                            @php [$grade, $remark] = getGradeStudent($exam->marks); @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-gray-800">{{ $exam->subject->name }}</td>
                                <td class="p-4 text-gray-600">{{ $exam->marks }}</td>
                                <td class="p-4">
                                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-bold">{{ $grade }}</span>
                                </td>
                                <td class="p-4 text-gray-600">{{ $remark }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-10">Your teacher hasn't posted any grades yet. Keep up the good work!</p>
        @endif
    @else
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
            Student profile not found. Please contact the Admin to link your account.
        </div>
    @endif
</div>
@endsection