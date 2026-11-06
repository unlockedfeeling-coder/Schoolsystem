<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-slate-900 text-white flex flex-col shadow-2xl z-20">
        <div class="h-20 flex items-center px-8 border-b border-slate-800">
            <i class="fas fa-graduation-cap text-3xl text-blue-500 mr-3"></i>
            <h1 class="text-xl font-bold tracking-wide">EduManage</h1>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="/dashboard" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-tachometer-alt w-6 text-center"></i><span class="font-medium">Dashboard</span>
            </a>
            <a href="/levels" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('levels') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-layer-group w-6 text-center"></i><span class="font-medium">Class Levels</span>
            </a>
            <a href="/sessions" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('sessions') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-calendar-alt w-6 text-center"></i><span class="font-medium">Academic Sessions</span>
            </a>
            <a href="/sections" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('sections') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-chalkboard-teacher w-6 text-center"></i><span class="font-medium">Sections</span>
            </a>
            <a href="/students" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('students') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-user-graduate w-6 text-center"></i><span class="font-medium">Students</span>
            </a>
            <a href="/teachers" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('teachers') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-chalkboard-user w-6 text-center"></i><span class="font-medium">Teachers</span>
            </a>
            <a href="/subjects" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('subjects') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-book w-6 text-center"></i><span class="font-medium">Subjects</span>
            </a>
            
            <!-- TIMETABLE LINK -->
            <a href="/timetable" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('timetable') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-clock w-6 text-center"></i><span class="font-medium">Timetable</span>
            </a>

            <a href="/attendance" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('attendance') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-clipboard-check w-6 text-center"></i><span class="font-medium">Attendance</span>
            </a>
            <a href="/exams" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('exams') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-file-alt w-6 text-center"></i><span class="font-medium">Exams & Grades</span>
            </a>
            <a href="/fees" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('fees') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-money-bill-wave w-6 text-center"></i><span class="font-medium">Fees & Finance</span>
            </a>
            <a href="/library" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('library') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-book-reader w-6 text-center"></i><span class="font-medium">Library</span>
            </a>
            <a href="/promotions" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('promotions') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-arrow-up w-6 text-center"></i><span class="font-medium">Promotions</span>
            </a>
            <a href="/announcements" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('announcements') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-bullhorn w-6 text-center"></i><span class="font-medium">Announcements</span>
            </a>
            <a href="/admissions" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('admissions') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-user-plus w-6 text-center"></i><span class="font-medium">Admissions</span>
            </a>
            <a href="/manage-users" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('manage-users') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-users-cog w-6 text-center"></i><span class="font-medium">Manage Users</span>
            </a>
            
            <a href="/change-password" class="flex items-center px-4 py-3 rounded-lg transition-colors text-slate-400 hover:bg-slate-800 hover:text-white border-t border-slate-800 mt-4 pt-4">
                <i class="fas fa-key w-6 text-center"></i><span class="font-medium">Change Password</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-900">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-red-500 transition" title="Logout">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-8 z-10">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
                <p class="text-sm text-gray-500">Welcome back, {{ auth()->user()->name }}</p>
            </div>
        </header>
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
            @yield('content')
        </main>
    </div>
    @livewireScripts
</body>
</html>