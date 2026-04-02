<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Boda Quick Loans')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb; /* Soft gray background */
        }
        .transition-fast {
            transition: all 0.2s ease-in-out;
        }
        a, button {
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-md py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600">Boda Quick Loans</a>

            <!-- Desktop nav -->
            <nav class="hidden md:flex space-x-6 items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-indigo-600 font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 font-medium">Register</a>
                @endauth
            </nav>

            <!-- Mobile toggle -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 focus:outline-none text-2xl">☰</button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white shadow-md mt-2 px-6 py-4 space-y-2 rounded-lg">
            @auth
                <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-indigo-600 font-medium">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left text-gray-700 hover:text-indigo-600 font-medium">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-gray-700 hover:text-indigo-600 font-medium">Login</a>
                <a href="{{ route('register') }}" class="block bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 font-medium">Register</a>
            @endauth
        </div>
    </header>

    <!-- Main content -->
    <main class="flex-1 py-12 px-6 max-w-7xl mx-auto">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto py-6">
        <div class="max-w-7xl mx-auto text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} Boda Quick Loans. All rights reserved.
        </div>
    </footer>

    <!-- Mobile toggle script -->
    <script>
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>