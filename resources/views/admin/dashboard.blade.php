@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">Welcome, Admin 👋</h1>
        <p class="mt-2 text-gray-500">Here’s the latest overview of your platform metrics.</p>
    </div>

    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

        <!-- Total Users Card -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white p-6 rounded-2xl shadow-lg transform transition hover:-translate-y-1 hover:shadow-2xl">
            <h2 class="font-semibold text-lg">Total Users</h2>
            <p class="text-3xl mt-2 font-bold">{{ \App\Models\User::count() }}</p>
            <p class="mt-1 text-indigo-100 text-sm">All registered users on the platform</p>
        </div>

        <!-- Total Agents Card -->
        <div class="bg-gradient-to-r from-green-400 to-teal-500 text-white p-6 rounded-2xl shadow-lg transform transition hover:-translate-y-1 hover:shadow-2xl">
            <h2 class="font-semibold text-lg">Total Agents</h2>
            <p class="text-3xl mt-2 font-bold">{{ \App\Models\User::where('is_agent', 1)->count() }}</p>
            <p class="mt-1 text-green-100 text-sm">Users with agent privileges</p>
        </div>

        <!-- Active Loans Card -->
        <div class="bg-gradient-to-r from-amber-400 to-red-500 text-white p-6 rounded-2xl shadow-lg transform transition hover:-translate-y-1 hover:shadow-2xl">
            <h2 class="font-semibold text-lg">Active Loans</h2>
            <p class="text-3xl mt-2 font-bold">{{ \App\Models\Loan::where('status', 'active')->count() }}</p>
            <p class="mt-1 text-amber-100 text-sm">Currently ongoing loans</p>
        </div>

    </div>

    <!-- Optional: Recent Users / Activity Section -->
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Recent Users</h2>
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection