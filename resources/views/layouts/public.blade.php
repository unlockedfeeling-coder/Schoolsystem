<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduManage International School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Navigation Bar (Updated with Modern Glass Effect) -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-3xl text-blue-600 mr-3"></i>
                    <span class="font-bold text-xl text-gray-900">EduManage School</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-600 hover:text-blue-600 font-medium">Home</a>
                    <a href="/news" class="text-gray-600 hover:text-blue-600 font-medium">News & Events</a>
                    <!-- FIXED: This now correctly links to /apply -->
                    <a href="/apply" class="text-green-600 hover:text-green-800 font-bold">Apply Now</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium">About Us</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium">Contact</a>
                    <a href="/login" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 font-bold shadow transition">
                        <i class="fas fa-lock mr-2"></i> Portal Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4 flex items-center"><i class="fas fa-graduation-cap mr-2 text-blue-400"></i> EduManage</h3>
                <p class="text-slate-400 text-sm">Empowering the next generation through excellence in education from KG to SHS.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-lg">Quick Links</h4>
                <ul class="space-y-2 text-slate-400 text-sm">
                    <li><a href="/" class="hover:text-white">Home</a></li>
                    <li><a href="/news" class="hover:text-white">News & Announcements</a></li>
                    <li><a href="/apply" class="hover:text-white">Apply for Admission</a></li>
                    <li><a href="/login" class="hover:text-white">Staff/Parent Portal</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-lg">Contact Us</h4>
                <ul class="space-y-2 text-slate-400 text-sm">
                    <li><i class="fas fa-map-marker-alt mr-2 text-blue-400"></i> 123 Education Lane, Accra</li>
                    <li><i class="fas fa-phone mr-2 text-blue-400"></i> +233 20 000 0000</li>
                    <li><i class="fas fa-envelope mr-2 text-blue-400"></i> info@edumanage.com</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-slate-800 mt-8 pt-8 text-center text-slate-500 text-sm">
            &copy; 2026 EduManage International School. All rights reserved.
        </div>
    </footer>

</body>
</html>