@extends('layouts.parent-app')
@section('content')
<div>
    @if(!$child)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded mb-6">
            <strong>Note:</strong> No child is currently linked to your account. Please contact the school administration.
        </div>
    @else
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-8 mb-8 text-white shadow-lg flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $child->first_name }} {{ $child->last_name }}</h1>
                <p class="text-indigo-100">Class: <span class="font-semibold">{{ $child->classLevel->name ?? 'N/A' }}</span> | Section: <span class="font-semibold">{{ $child->section->name ?? 'N/A' }}</span></p>
                <p class="text-indigo-100 mt-1">Admission #: {{ $child->admission_number }}</p>
            </div>
            <i class="fas fa-user-graduate text-6xl text-white opacity-20"></i>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center"><i class="fas fa-clipboard-check text-green-500 mr-2"></i> Attendance</h3>
                <div class="space-y-2">
                    <div class="flex justify-between"><span class="text-gray-600">Present</span><span class="font-bold text-green-600">{{ $attendance['Present'] ?? 0 }} Days</span></div>
                    <div class="flex justify-between"><span class="text-gray-600">Absent</span><span class="font-bold text-red-600">{{ $attendance['Absent'] ?? 0 }} Days</span></div>
                    <div class="flex justify-between"><span class="text-gray-600">Late</span><span class="font-bold text-yellow-600">{{ $attendance['Late'] ?? 0 }} Days</span></div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center"><i class="fas fa-file-invoice-dollar text-purple-500 mr-2"></i> Fee Balance</h3>
                <div class="space-y-2">
                    <div class="flex justify-between"><span class="text-gray-600">Total Billed</span><span class="font-bold text-gray-800">${{ number_format($totalFees, 2) }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-600">Total Paid</span><span class="font-bold text-green-600">${{ number_format($paidFees, 2) }}</span></div>
                    <div class="flex justify-between pt-2 border-t"><span class="text-gray-800 font-semibold">Balance Due</span><span class="font-bold text-red-600 text-xl">${{ number_format($totalFees - $paidFees, 2) }}</span></div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center"><i class="fas fa-chart-line text-blue-500 mr-2"></i> Recent Grades</h3>
                @if($exams->count() > 0)
                    <div class="space-y-2">
                        @foreach($exams->take(3) as $exam)
                            <div class="flex justify-between items-center border-b border-gray-100 pb-2 last:border-0">
                                <span class="text-gray-600 text-sm">{{ $exam->subject->name ?? 'Unknown' }}</span>
                                <span class="font-bold text-blue-600">{{ $exam->marks }}/100</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-sm">No grades posted yet.</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection