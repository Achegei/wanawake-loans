@extends('layouts.admin')

@section('title', 'Edit Agent')

@section('content')

<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow">

    <h1 class="text-xl font-bold mb-4">Edit Sales Agent</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.agents.update', $agent->id) }}">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-4">
            <label class="block text-sm mb-1">Name</label>
            <input type="text" name="name"
                   class="w-full border rounded-lg px-3 py-2"
                   value="{{ old('name', $agent->name) }}"
                   required>
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label class="block text-sm mb-1">Phone</label>
            <input type="text" name="phone"
                   class="w-full border rounded-lg px-3 py-2"
                   value="{{ old('phone', $agent->phone) }}"
                   required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded-lg px-3 py-2"
                   value="{{ old('email', $agent->email) }}"
                   required>
        </div>

        <!-- ID Number -->
        <div class="mb-4">
            <label class="block text-sm mb-1">ID Number</label>
            <input type="text" name="id_number"
                   class="w-full border rounded-lg px-3 py-2"
                   value="{{ old('id_number', $agent->id_number) }}"
                   required>
        </div>

        <!-- Password (Optional) -->
        <div class="mb-4">
            <label class="block text-sm mb-1">New Password (optional)</label>
            <input type="password" name="password"
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.agents.index') }}"
               class="text-gray-500 hover:underline">
                ← Back
            </a>

            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Update Agent
            </button>
        </div>

    </form>

</div>

@endsection