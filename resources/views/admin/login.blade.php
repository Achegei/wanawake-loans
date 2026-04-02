@extends('layouts.admin-login')

@section('title', 'Admin Login')

@section('content')
<div class="relative w-full h-screen bg-gray-100 overflow-hidden">

    {{-- Background Image --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/motorbikes-bg.jpg') }}" 
             alt="Background" 
             class="w-full h-full object-cover opacity-80">
        <div class="absolute inset-0 bg-black/40"></div> {{-- overlay for contrast --}}
    </div>

    {{-- Login Card --}}
    <div class="absolute left-8 bottom-16 md:left-16 md:bottom-24 bg-white bg-opacity-90 backdrop-blur-md rounded-xl shadow-2xl p-8 w-full max-w-sm">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Admin Login</h1>

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       required autofocus>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-300">
                Login
            </button>
        </form>
    </div>

</div>
@endsection