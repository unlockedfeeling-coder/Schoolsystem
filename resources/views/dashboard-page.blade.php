@extends('layouts.app')

@section('content')
<div>
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 mb-8 text-white shadow-lg flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2">Welcome back, Administrator!</h1>
            <p class="text-blue-100">Here is what is happening in your school today.</p>
        </div>
        <i class="fas fa-school text-6xl text-white opacity-20"></i>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Students Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Students</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalStudents }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
        </div>

        <!-- Classes Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Class Levels</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalClasses }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                <i class="fas fa-layer-group text-xl"></i>
            </div>
        </div>

        <!-- Sections Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Sections</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSections }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                <i class="fas fa-chalkboard-teacher text-xl"></i>
            </div>
        </div>

        <!-- Sessions Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Academic Sessions</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSessions }}</h3>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
        </div>

    </div>

    <!-- Quick Actions -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="flex gap-4">
            <a href="/students" class="bg-blue-50 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-100 transition font-medium">
                <i class="fas fa-plus mr-2"></i> Register Student
            </a>
            <a href="/sessions" class="bg-purple-50 text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-100 transition font-medium">
                <i class="fas fa-calendar-plus mr-2"></i> New Session
            </a>
        </div>
    </div>
</div>
@endsection