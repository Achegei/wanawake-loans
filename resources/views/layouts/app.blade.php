<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Boda Quick Loans')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #fdf6f0; /* soft cream background */
            font-family: 'Inter', sans-serif;
        }
        .shadow-lg {
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        a {
            transition: all 0.2s;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow py-4">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold text-amber-500">Boda Quick Loans</a>

            <!-- Desktop nav -->
            <nav class="hidden md:flex flex-wrap items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-amber-500">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-amber-500">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-amber-500">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-amber-500">Register</a>
                @endauth
            </nav>

            <!-- Mobile menu toggle -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">☰</button>
            </div>
        </div>

        <!-- Mobile nav (hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden bg-white px-4 pt-2 pb-4 space-y-2">
            @auth
                <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-amber-500">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit" class="text-gray-700 hover:text-amber-500">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-gray-700 hover:text-amber-500">Login</a>
                <a href="{{ route('register') }}" class="block text-gray-700 hover:text-amber-500">Register</a>
            @endauth
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t py-4 mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Boda Quick Loans. All rights reserved.
        </div>
    </footer>

    <!-- Mobile menu toggle script -->
    <script>
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>