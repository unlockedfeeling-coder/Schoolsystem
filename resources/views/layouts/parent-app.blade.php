<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-purple-900 text-white flex flex-col shadow-2xl z-20">
        <div class="h-20 flex items-center px-8 border-b border-purple-800">
            <i class="fas fa-user-friends text-3xl text-purple-300 mr-3"></i>
            <h1 class="text-xl font-bold tracking-wide">Parent Portal</h1>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="/parent/dashboard" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('parent/dashboard') ? 'bg-purple-600 text-white shadow-lg' : 'text-purple-200 hover:bg-purple-800 hover:text-white' }}">
                <i class="fas fa-tachometer-alt w-6 text-center"></i><span class="font-medium">Dashboard</span>
            </a>
            <a href="/parent/grades" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('parent/grades') ? 'bg-purple-600 text-white shadow-lg' : 'text-purple-200 hover:bg-purple-800 hover:text-white' }}">
                <i class="fas fa-graduation-cap w-6 text-center"></i><span class="font-medium">Grades & Report</span>
            </a>
            <a href="/parent/attendance" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('parent/attendance') ? 'bg-purple-600 text-white shadow-lg' : 'text-purple-200 hover:bg-purple-800 hover:text-white' }}">
                <i class="fas fa-calendar-check w-6 text-center"></i><span class="font-medium">Attendance</span>
            </a>
            <a href="/parent/fees" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('parent/fees') ? 'bg-purple-600 text-white shadow-lg' : 'text-purple-200 hover:bg-purple-800 hover:text-white' }}">
                <i class="fas fa-money-bill-wave w-6 text-center"></i><span class="font-medium">Fees & Receipts</span>
            </a>
            
            <!-- CHANGE PASSWORD LINK -->
            <a href="/change-password" class="flex items-center px-4 py-3 rounded-lg transition-colors text-purple-200 hover:bg-purple-800 hover:text-white border-t border-purple-800 mt-4 pt-4">
                <i class="fas fa-key w-6 text-center"></i><span class="font-medium">Change Password</span>
            </a>
        </nav>

        <div class="p-4 border-t border-purple-800 bg-purple-900">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-purple-300">Parent</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-purple-300 hover:text-red-400 transition" title="Logout">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-8 z-10">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Parent Dashboard</h2>
                <p class="text-sm text-gray-500">Welcome back, {{ auth()->user()->name }}</p>
            </div>
        </header>
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>