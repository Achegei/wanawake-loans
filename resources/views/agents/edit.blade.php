@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-12 bg-white p-6 rounded-2xl shadow-lg">

    <h1 class="text-2xl font-bold mb-4">Edit Sales Agent</h1>

    {{-- Errors --}}
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

        {{-- Name --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Name</label>
            <input type="text" name="name"
                   value="{{ old('name', $agent->name) }}"
                   class="border p-2 w-full rounded"
                   required>
        </div>

        {{-- Phone --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Phone</label>
            <input type="text" name="phone"
                   value="{{ old('phone', $agent->phone) }}"
                   class="border p-2 w-full rounded"
                   required>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Email</label>
            <input type="email" name="email"
                   value="{{ old('email', $agent->email) }}"
                   class="border p-2 w-full rounded"
                   required>
        </div>

        {{-- ID Number --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">ID Number</label>
            <input type="text" name="id_number"
                   value="{{ old('id_number', $agent->id_number) }}"
                   class="border p-2 w-full rounded"
                   required>
        </div>

        {{-- Agent Code (readonly) --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Agent Code</label>
            <input type="text"
                   value="{{ $agent->code }}"
                   class="border p-2 w-full rounded bg-gray-100"
                   readonly>
        </div>

        {{-- Optional: Reset Password --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">New Password (optional)</label>
            <input type="password" name="password"
                   class="border p-2 w-full rounded">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="border p-2 w-full rounded">
        </div>

        {{-- Actions --}}
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.agents.index') }}"
               class="text-gray-600 hover:underline">
                ← Back
            </a>

            <button type="submit"
                class="bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">
                Update Agent
            </button>
        </div>

    </form>
</div>
@endsection