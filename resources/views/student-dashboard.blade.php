@extends('layouts.student-app')
@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Welcome, {{ auth()->user()->name }}!</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-emerald-50 p-6 rounded-xl border border-emerald-100">
            <h3 class="text-emerald-800 font-bold mb-2">My Class</h3>
            <p class="text-2xl font-bold text-emerald-900">Basic 1</p>
        </div>
        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
            <h3 class="text-blue-800 font-bold mb-2">Current Term</h3>
            <p class="text-2xl font-bold text-blue-900">1st Trimester</p>
        </div>
        <div class="bg-purple-50 p-6 rounded-xl border border-purple-100">
            <h3 class="text-purple-800 font-bold mb-2">Announcements</h3>
            <p class="text-2xl font-bold text-purple-900">3 New</p>
        </div>
    </div>
</div>
@endsection