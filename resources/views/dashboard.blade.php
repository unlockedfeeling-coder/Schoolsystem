<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen p-10">
    
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">School Admin Dashboard</h1>
        
        <div class="flex gap-4 mb-8">
            <a href="/levels" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Manage Class Levels</a>
            <a href="/students" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Manage Students</a>
        </div>

        <!-- This is where the page content will load -->
        @yield('content')
    </div>

    @livewireScripts
</body>
</html>