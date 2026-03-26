<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wanawake Loans')</title>
    
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
        <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold text-amber-500">Wanawake Loans</a>
            <nav>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-amber-500 ml-6">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-amber-500 ml-6">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-amber-500 ml-6">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-amber-500 ml-6">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 py-12">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t py-4 mt-auto">
        <div class="max-w-6xl mx-auto px-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Wanawake Loans. All rights reserved.
        </div>
    </footer>

</body>
</html>