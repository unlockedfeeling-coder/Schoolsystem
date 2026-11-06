@extends('layouts.public')

@section('content')
<!-- Modern Hero Section with Background Image -->
<div class="relative h-[600px] flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('images/school-bg.png') }}');">
    
    <!-- Dark Overlay to make text readable -->
    <div class="absolute inset-0 bg-slate-900/75"></div>

    <!-- Hero Content -->
    <div class="relative z-10 text-center text-white px-4 max-w-5xl mx-auto">
        <p class="text-blue-300 font-bold tracking-[0.2em] uppercase mb-4 text-sm">Welcome to EduManage International School</p>
        <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight leading-tight drop-shadow-lg">
            Shaping the Future, <br> <span class="text-blue-400">One Student at a Time.</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-200 mb-10 max-w-3xl mx-auto drop-shadow-md">
            Experience world-class education in a modern, serene environment designed to nurture academic excellence and personal growth.
        </p>
        
        <div class="flex flex-col md:flex-row justify-center gap-4">
            <a href="/news" class="bg-blue-600 text-white px-8 py-3.5 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg hover:shadow-blue-500/50 border border-blue-500">
                Latest News & Events
            </a>
            <a href="/login" class="bg-white/10 backdrop-blur-md text-white px-8 py-3.5 rounded-lg font-bold hover:bg-white/20 transition shadow-lg border border-white/30">
                <i class="fas fa-lock mr-2"></i> Portal Login
            </a>
        </div>
    </div>
</div>

<!-- Booking/Info Bar (Overlapping the Hero) -->
<div class="relative z-20 max-w-6xl mx-auto px-4 -mt-16">
    <div class="bg-white rounded-xl shadow-2xl p-6 grid grid-cols-1 md:grid-cols-4 gap-6 items-center border border-gray-100">
        <div class="text-center md:text-left border-b md:border-b-0 md:border-r border-gray-200 pb-4 md:pb-0">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Academic Year</p>
            <p class="text-xl font-bold text-slate-800">2024 - 2025</p>
        </div>
        <div class="text-center md:text-left border-b md:border-b-0 md:border-r border-gray-200 pb-4 md:pb-0">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Students</p>
            <p class="text-xl font-bold text-slate-800">1,200+</p>
        </div>
        <div class="text-center md:text-left border-b md:border-b-0 md:border-r border-gray-200 pb-4 md:pb-0">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Qualified Staff</p>
            <p class="text-xl font-bold text-slate-800">85+</p>
        </div>
        <div class="text-center md:text-left">
            <!-- FIXED: This now correctly links to /apply -->
            <a href="/apply" class="block w-full bg-slate-900 text-white text-center px-6 py-3 rounded-lg font-bold hover:bg-slate-800 transition shadow-md">
                Apply Now <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="text-center mb-16">
        <span class="text-blue-600 font-bold uppercase tracking-wider text-sm">Why Choose Us</span>
        <h2 class="text-4xl font-bold text-gray-900 mt-2">A Foundation for Excellence</h2>
        <p class="text-gray-600 mt-4 max-w-2xl mx-auto">We provide a holistic education that prepares students for the future through innovation, dedication, and care.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-xl hover:-translate-y-2 transition duration-300">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-600 text-3xl shadow-inner">
                <i class="fas fa-book-open"></i>
            </div>
            <h3 class="text-2xl font-bold mb-3 text-gray-800">Academic Excellence</h3>
            <p class="text-gray-600 leading-relaxed">A rigorous, globally recognized curriculum designed to challenge and inspire students at every level of their journey.</p>
        </div>
        <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-xl hover:-translate-y-2 transition duration-300">
            <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 text-green-600 text-3xl shadow-inner">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="text-2xl font-bold mb-3 text-gray-800">Dedicated Teachers</h3>
            <p class="text-gray-600 leading-relaxed">Our highly qualified and passionate staff are committed to the personal and academic growth of every single child.</p>
        </div>
        <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-xl hover:-translate-y-2 transition duration-300">
            <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-6 text-purple-600 text-3xl shadow-inner">
                <i class="fas fa-laptop-code"></i>
            </div>
            <h3 class="text-2xl font-bold mb-3 text-gray-800">Modern Facilities</h3>
            <p class="text-gray-600 leading-relaxed">State-of-the-art classrooms, science labs, and digital portals for a seamless, 21st-century learning experience.</p>
        </div>
    </div>
</div>

<!-- Latest Announcements -->
<div class="bg-slate-50 py-24 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <span class="text-blue-600 font-bold uppercase tracking-wider text-sm">Stay Updated</span>
                <h2 class="text-4xl font-bold text-gray-900 mt-2">Latest News & Events</h2>
            </div>
            <a href="/news" class="text-blue-600 font-bold hover:text-blue-800 transition mt-4 md:mt-0 flex items-center">
                View All News <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($announcements as $news)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition duration-300 flex flex-col group">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-8 flex-grow">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-1.5 rounded-full uppercase tracking-wider">
                            {{ \Carbon\Carbon::parse($news->date)->format('M d, Y') }}
                        </span>
                        <h3 class="text-xl font-bold text-gray-900 mt-6 mb-4 group-hover:text-blue-600 transition">{{ $news->title }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">{{ Str::limit($news->content, 120) }}</p>
                    </div>
                    <div class="px-8 py-4 bg-gray-50 border-t border-gray-100">
                        <a href="/news" class="text-sm font-bold text-slate-700 hover:text-blue-600 transition">Read More &rarr;</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-3 text-center py-10">No recent announcements.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection