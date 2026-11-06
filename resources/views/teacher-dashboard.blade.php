@extends('layouts.teacher-app')

@section('content')
<div class="bg-emerald-50 border-l-4 border-emerald-500 p-6 rounded-lg mb-8 shadow-sm">
    <h2 class="text-3xl font-bold text-emerald-800">Welcome, {{ auth()->user()->name }}!</h2>
    <p class="text-emerald-700 mt-2">Here is an overview of your assigned classes and daily tasks.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Assigned Class -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Assigned Class</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">
                {{ $myClass->classLevel->name ?? 'None Assigned' }}
            </p>
        </div>
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl">
            <i class="fas fa-layer-group"></i>
        </div>
    </div>

    <!-- Total Students -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Total Students</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">
                {{ $totalStudents }}
            </p>
        </div>
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl">
            <i class="fas fa-user-graduate"></i>
        </div>
    </div>

    <!-- Subject -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Subject</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">
                {{ $myClass->subject->name ?? 'General' }}
            </p>
        </div>
        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 text-xl">
            <i class="fas fa-book"></i>
        </div>
    </div>
</div>

<!-- Daily Tasks -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h3 class="text-xl font-bold text-gray-800 mb-6">Daily Tasks</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="/teacher/attendance" class="flex items-center p-4 border-2 border-emerald-100 rounded-lg hover:bg-emerald-50 transition group">
            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 mr-4 group-hover:bg-emerald-600 group-hover:text-white transition">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div>
                <p class="font-bold text-gray-800">Mark Today's Attendance</p>
                <p class="text-sm text-gray-500">Record student presence for today.</p>
            </div>
        </a>
        
        <a href="/teacher/exams" class="flex items-center p-4 border-2 border-blue-100 rounded-lg hover:bg-blue-50 transition group">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-4 group-hover:bg-blue-600 group-hover:text-white transition">
                <i class="fas fa-pen"></i>
            </div>
            <div>
                <p class="font-bold text-gray-800">Enter Test Scores</p>
                <p class="text-sm text-gray-500">Update grades for your subject.</p>
            </div>
        </a>
    </div>
</div>
@endsection