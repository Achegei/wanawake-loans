@extends('layouts.auth')

@section('title', 'Register')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2 class="text-2xl font-bold text-gray-900 mb-2">Create Account</h2>
<p class="text-gray-500 mb-6">Start your financial journey</p>

<form method="POST" action="{{ route('register') }}" class="space-y-3"> <!-- reduced spacing -->
    @csrf

    <div>
        <label class="text-sm text-gray-600">Full Name (as ID)</label>
        <input type="text" name="name" required
            class="w-full mt-1 px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-400 focus:outline-none"> <!-- reduced py -->
    </div>

    <div>
        <label class="text-sm text-gray-600">Email</label>
        <input type="email" name="email" required
            class="w-full mt-1 px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-400 focus:outline-none">
    </div>

    <div>
        <label class="text-sm text-gray-600">Phone Number</label>
        <input type="text" name="phone" placeholder="07XXXXXXXX" required
            class="w-full mt-1 px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-400 focus:outline-none">
    </div>

    <div>
        <label class="text-sm text-gray-600">Password</label>
        <input type="password" name="password" required
            class="w-full mt-1 px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-400 focus:outline-none">
    </div>

    <div>
        <label class="text-sm text-gray-600">Confirm Password</label>
        <input type="password" name="password_confirmation" required
            class="w-full mt-1 px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-400 focus:outline-none">
    </div>

    <button type="submit"
        class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-xl font-semibold transition">
        Create Account
    </button>

    <p class="text-sm text-center text-gray-500">
        Already have an account?
        <a href="{{ route('login') }}" class="text-amber-600 font-medium">Login</a>
    </p>
</form>
@endsection