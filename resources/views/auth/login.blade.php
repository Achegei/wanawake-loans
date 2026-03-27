@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back</h2>
<p class="text-gray-500 mb-6">Sign in to your account</p>

<form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf

    <div>
        <label class="text-sm text-gray-600">Phone Number</label>
        <input type="text" name="phone" required
            placeholder="07XXXXXXXX"
            class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-400 focus:outline-none">
    </div>

    <div>
        <label class="text-sm text-gray-600">Password</label>
        <input type="password" name="password" required
            class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-400 focus:outline-none">
    </div>

    <button type="submit"
        class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-xl font-semibold transition">
        Login
    </button>

    <p class="text-sm text-center text-gray-500">
        Don’t have an account?
        <a href="{{ route('register') }}" class="text-amber-600 font-medium">Register</a>
    </p>

</form>

@endsection