<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    @vite('resources/css/app.css')
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex font-sans">

    {{-- Sidebar --}}
    <aside class="w-64 min-h-screen hidden md:flex flex-col bg-gradient-to-b from-indigo-600 to-indigo-800 text-white shadow-lg">
        <div class="p-6 text-2xl font-bold border-b border-indigo-500">
            Admin Panel
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      {{ request()->routeIs('admin.dashboard') ? 'bg-white text-indigo-700 font-semibold shadow-lg' : 'hover:bg-indigo-500/30' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.agents.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      {{ request()->routeIs('admin.agents.*') ? 'bg-white text-indigo-700 font-semibold shadow-lg' : 'hover:bg-indigo-500/30' }}">
                Agents
            </a>

            {{-- Add more links here --}}
        </nav>

        <form action="{{ route('admin.logout') }}" method="POST" class="p-4 border-t border-indigo-500">
            @csrf
            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium shadow">
                Logout
            </button>
        </form>
    </aside>

    {{-- Mobile Sidebar --}}
    <div class="md:hidden fixed inset-0 z-30 bg-black bg-opacity-50 hidden" id="mobile-overlay"></div>
    <div class="md:hidden fixed inset-y-0 left-0 w-64 bg-indigo-700 text-white shadow-lg transform -translate-x-full transition-transform duration-300" id="mobile-sidebar">
        <div class="p-6 text-2xl font-bold border-b border-indigo-500 flex justify-between items-center">
            Admin Panel
            <button class="text-white text-3xl font-bold" id="mobile-close">&times;</button>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-indigo-500/30">
                Dashboard
            </a>
            <a href="{{ route('admin.agents.index') }}" class="block px-4 py-3 rounded-lg hover:bg-indigo-500/30">
                Agents
            </a>
        </nav>
        <form action="{{ route('admin.logout') }}" method="POST" class="p-4 border-t border-indigo-500">
            @csrf
            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium shadow">
                Logout
            </button>
        </form>
    </div>

    {{-- Main Content --}}
    <main class="flex-1 p-6">
        <header class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
            <button class="md:hidden bg-indigo-600 text-white p-2 rounded-lg shadow" id="mobile-toggle">
                ☰
            </button>
        </header>

        <div>
            @yield('content')
        </div>
    </main>

    @stack('scripts')

    {{-- Mobile sidebar toggle --}}
    <script>
        const toggleBtn = document.getElementById('mobile-toggle');
        const closeBtn = document.getElementById('mobile-close');
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('mobile-overlay');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>
</html>