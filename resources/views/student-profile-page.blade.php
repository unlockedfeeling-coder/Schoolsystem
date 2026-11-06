@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
    
    <!-- Header with Print Button -->
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $student->first_name }} {{ $student->last_name }}</h2>
            <p class="text-gray-500">Admission Number: {{ $student->admission_number }}</p>
        </div>
        <a href="/students/{{ $student->id }}/report" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 font-bold shadow-md transition flex items-center">
            <i class="fas fa-file-alt mr-2"></i> View & Print Report Card
        </a>
    </div>

    <!-- Student Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="font-bold text-gray-700 mb-2">Personal Information</h3>
            <p class="text-sm text-gray-600"><strong>Date of Birth:</strong> {{ $student->date_of_birth }}</p>
            <p class="text-sm text-gray-600"><strong>Gender:</strong> {{ $student->gender }}</p>
            <p class="text-sm text-gray-600"><strong>Class:</strong> {{ $student->classLevel->name ?? 'N/A' }}</p>
            <p class="text-sm text-gray-600"><strong>Section:</strong> {{ $student->section->name ?? 'N/A' }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="font-bold text-gray-700 mb-2">Remarks (For Report Card)</h3>
            <div class="mb-2">
                <label class="block text-xs font-bold text-gray-500 uppercase">Teacher's Remark</label>
                <textarea class="w-full border border-gray-300 rounded p-2 text-sm" rows="2">{{ $student->teacher_remark }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase">Principal's Remark</label>
                <textarea class="w-full border border-gray-300 rounded p-2 text-sm" rows="2">{{ $student->principal_remark }}</textarea>
            </div>
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="/students" class="text-blue-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i> Back to Students List</a>
    </div>
</div>
@endsection