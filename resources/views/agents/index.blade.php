@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-12">
    <h1 class="text-2xl font-bold mb-6">Sales Agents</h1>

    <table class="w-full border rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Phone</th>
                <th class="p-2 border">Permanent Code</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agents as $agent)
            <tr>
                <td class="p-2 border">{{ $agent->name }}</td>
                <td class="p-2 border">{{ $agent->phone }}</td>
                <td class="p-2 border">{{ $agent->code }}</td>
                <td class="p-2 border">
                    <form action="{{ route('agents.generateCode', $agent) }}" method="POST">
                        @csrf
                        <button class="text-blue-600 hover:underline" type="submit">Generate Dynamic Code</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection