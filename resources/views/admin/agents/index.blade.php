@extends('layouts.admin')

@section('title', 'Sales Agents')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Sales Agents</h1>

    <a href="{{ route('admin.agents.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
        + New Agent
    </a>
</div>

{{-- Show success message --}}
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
        {{ session('success') }}
    </div>
@endif

{{-- Show temp password for newly created agent --}}
@if(session('temp_password') && session('agent_code'))
    <div class="mb-4 p-3 bg-yellow-100 text-yellow-800 rounded-lg">
        New Agent Created! <br>
        Code: <strong>{{ session('agent_code') }}</strong> <br>
        Temporary Password: <strong>{{ session('temp_password') }}</strong>
    </div>
@endif

<div class="bg-white rounded-xl shadow overflow-x-auto">

    <table class="w-full text-sm min-w-[700px]">

        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="p-3 text-left w-12">#</th>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Phone</th>
                <th class="p-3 text-left">Agent Code</th>
                <th class="p-3 text-left w-28">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y">

            @forelse($agents as $agent)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="p-3 font-medium">{{ $agent->name }}</td>
                    <td class="p-3">{{ $agent->phone }}</td>
                    <td class="p-3 font-mono">{{ $agent->latestAccessCode?->code ?? '—' }}</td>
                    <td class="p-3">
                        <a href="{{ route('admin.agents.edit', $agent->id) }}"
                           class="text-indigo-600 hover:underline">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">
                        No agents yet
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>

@endsection