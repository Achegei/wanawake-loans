@extends('layouts.auth')

@section('title', 'Agent Login')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 px-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 relative overflow-hidden">

        <!-- Background Circles -->
        <div class="absolute -top-16 -right-16 w-48 h-48 bg-indigo-200 rounded-full opacity-30 animate-pulse"></div>
        <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-pink-200 rounded-full opacity-20 animate-pulse"></div>

        <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-2">Welcome, Agent</h2>
        <p class="text-gray-500 text-center mb-8">Sign in to access your dashboard</p>

        <form method="POST" action="{{ route('agent.login.submit') }}" class="space-y-6">
            @csrf

            <!-- Phone Number -->
            <div>
                <label class="block text-sm font-medium text-gray-600">Phone Number</label>
                <input type="text" name="phone" required
                    placeholder="07XXXXXXXX"
                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-shadow shadow-sm hover:shadow-md">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password" required
                    placeholder="********"
                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-shadow shadow-sm hover:shadow-md">
            </div>

            <!-- Error -->
            @if($errors->any())
                <p class="text-red-500 text-sm text-center">{{ $errors->first() }}</p>
            @endif

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 hover:from-indigo-600 hover:via-purple-600 hover:to-pink-600 text-white py-3 rounded-xl font-semibold text-lg transition transform hover:-translate-y-0.5 shadow-lg hover:shadow-2xl">
                Sign In
            </button>

            <p class="text-sm text-center text-gray-500 mt-4">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">Register</a>
            </p>
        </form>

    </div>
</div>

<!-- Animations -->
<style>
@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.3; }
    50% { transform: scale(1.1); opacity: 0.5; }
}
.animate-pulse {
    animation: pulse 6s ease-in-out infinite;
}
</style>

@endsection