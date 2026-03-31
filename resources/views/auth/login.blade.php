@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<!-- Moto Icon Sliding In -->
<div class="absolute -left-10 top-0 md:top-10 w-16 h-16 animate-slideInLeft hidden md:block z-10">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-full h-full">
        <circle cx="16" cy="48" r="8" fill="#F59E0B"/>
        <circle cx="48" cy="48" r="8" fill="#F59E0B"/>
        <rect x="12" y="24" width="40" height="16" fill="#F59E0B"/>
        <polygon points="40,24 52,24 56,16 44,16" fill="#F59E0B"/>
    </svg>
</div>

<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2 drop-shadow-sm">
    Welcome Back
</h2>
<p class="text-gray-500 mb-6">Sign in to your account</p>

<form method="POST" action="{{ route('login') }}" class="space-y-5 relative z-20">
    @csrf

    <div>
        <label class="text-sm text-gray-600">Phone Number</label>
        <input type="text" name="phone" required
            placeholder="07XXXXXXXX"
            class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-400 focus:outline-none transition-shadow shadow-sm hover:shadow-md">
    </div>

    <div>
        <label class="text-sm text-gray-600">Password</label>
        <input type="password" name="password" required
            class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-400 focus:outline-none transition-shadow shadow-sm hover:shadow-md">
    </div>

    <button type="submit"
        class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-xl font-semibold transition transform hover:-translate-y-0.5 shadow-lg hover:shadow-2xl">
        Login
    </button>

    <p class="text-sm text-center text-gray-500">
        Don’t have an account?
        <a href="{{ route('register') }}" class="text-amber-600 font-medium hover:underline">Register</a>
    </p>

</form>

<!-- Tailwind Animations -->
<style>
@keyframes slideInLeft {
    0% { transform: translateX(-150%); opacity: 0; }
    100% { transform: translateX(0); opacity: 1; }
}
.animate-slideInLeft {
    animation: slideInLeft 1s ease-out forwards;
}
</style>

@endsection