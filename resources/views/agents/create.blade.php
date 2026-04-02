@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-12 bg-white p-6 rounded-2xl shadow-lg">
    <h1 class="text-2xl font-bold mb-4">Add Sales Agent</h1>

    <form action="{{ route('agents.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold mb-1">Name</label>
            <input type="text" name="name" class="border p-2 w-full rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Phone</label>
            <input type="text" name="phone" class="border p-2 w-full rounded" required>
        </div>

        <button type="submit" class="bg-amber-500 text-white py-2 px-4 rounded hover:bg-amber-600">
            Create Agent
        </button>
    </form>
</div>
@endsection