<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Agent Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-emerald-600 to-emerald-800 text-white flex flex-col">

        <div class="p-6 text-2xl font-bold border-b border-emerald-500">
            Agent Panel
        </div>

        <nav class="flex-1 p-4 space-y-2">

            <a href="{{ route('agent.dashboard') }}"
               class="block px-4 py-2 rounded-lg hover:bg-white/10 transition">
                Dashboard
            </a>

            <a href="{{ route('agent.loans') }}"
               class="block px-4 py-2 rounded-lg hover:bg-white/10 transition">
                My Loans
            </a>

        </nav>

        <div class="p-4 border-t border-emerald-500">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-white/10 hover:bg-white/20 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</div>

</body>
</html>