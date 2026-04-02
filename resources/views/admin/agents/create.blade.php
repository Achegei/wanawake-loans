@extends('layouts.admin')

@section('title', 'Create Agent')

@section('content')

<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow">

    <h1 class="text-xl font-bold mb-4">Create Sales Agent</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.agents.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm mb-1">Name</label>
            <input type="text" name="name"
                   class="w-full border rounded-lg px-3 py-2"
                   value="{{ old('name') }}"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Phone</label>
            <input type="text" name="phone"
                   class="w-full border rounded-lg px-3 py-2"
                   value="{{ old('phone') }}"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded-lg px-3 py-2"
                   value="{{ old('email') }}"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">ID Number</label>
            <input type="text" name="id_number"
                   class="w-full border rounded-lg px-3 py-2"
                   value="{{ old('id_number') }}"
                   required>
        </div>

        <!-- Password Fields -->
        <div class="mb-4">
            <label class="block text-sm mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded-lg px-3 py-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border rounded-lg px-3 py-2"
                   required>
        </div>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
            Create Agent
        </button>

    </form>

</div>

@endsection