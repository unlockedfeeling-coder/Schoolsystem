@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900">News & Announcements</h1>
        <p class="text-gray-600 mt-4">Official updates, events, and notices from the school administration.</p>
    </div>

    <div class="space-y-6">
        @forelse($announcements as $news)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" class="w-full h-64 object-cover">
                @endif
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-bold text-blue-600 bg-blue-50 px-4 py-1.5 rounded-full">
                            <i class="far fa-calendar-alt mr-2"></i> {{ \Carbon\Carbon::parse($news->date)->format('F d, Y') }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $news->title }}</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $news->content }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-xl border border-gray-200">
                <i class="far fa-newspaper text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">No announcements have been published yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection