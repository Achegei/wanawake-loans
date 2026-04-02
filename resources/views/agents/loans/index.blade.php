@extends('layouts.agent')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900">All Loans</h1>
            <p class="text-gray-600 mt-2">A detailed list of all your loans with status and user info.</p>
        </div>

        <!-- Filter Form -->
        <form method="GET" class="mb-6 flex flex-col md:flex-row gap-4 items-center">
            <div>
                <label for="from" class="block text-sm font-medium text-gray-700">From</label>
                <input type="date" name="from" id="from" value="{{ request('from') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="to" class="block text-sm font-medium text-gray-700">To</label>
                <input type="date" name="to" id="to" value="{{ request('to') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mt-5 md:mt-6">
                <button type="submit"
                        class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-6 py-2 rounded-xl shadow-lg font-semibold hover:scale-105 transition-transform">
                    Filter
                </button>
            </div>
        </form>

        <!-- Loans Table -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Loan ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">User</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Amount</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Created At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($loans as $loan)
                    <tr>
                        <td class="px-6 py-4">{{ $loan->id }}</td>
                        <td class="px-6 py-4">{{ $loan->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">KES{{ number_format($loan->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            @if($loan->status === 'paid')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">Paid</span>
                            @elseif($loan->status === 'pending')
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold">Pending</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-xs font-semibold">{{ ucfirst($loan->status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $loan->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No loans found for the selected period.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Back Button -->
        <div class="mt-10">
            <a href="{{ route('agent.dashboard') }}"
               class="inline-block bg-gray-200 text-gray-900 px-6 py-2 rounded-xl shadow hover:bg-gray-300 transition">
                Back to Dashboard
            </a>
        </div>

    </div>
</div>
@endsection