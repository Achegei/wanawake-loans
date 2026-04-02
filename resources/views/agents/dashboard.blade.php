@extends('layouts.agent')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- Dashboard Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900">{{ auth()->user()->name }} Dashboard</h1>
            <p class="text-gray-600 mt-2">Welcome, {{ auth()->user()->name }}. Here’s a snapshot of your loan activity.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white shadow-lg rounded-xl p-6 border-l-8 border-indigo-500">
                <h3 class="text-gray-500 font-medium">Total Loans</h3>
                <p class="text-3xl font-bold mt-2 text-gray-900">{{ $loansCount }}</p>
            </div>

            <div class="bg-white shadow-lg rounded-xl p-6 border-l-8 border-yellow-400">
                <h3 class="text-gray-500 font-medium">Pending Loans</h3>
                <p class="text-3xl font-bold mt-2 text-gray-900">{{ $pendingLoans }}</p>
            </div>

            <div class="bg-white shadow-lg rounded-xl p-6 border-l-8 border-green-500">
                <h3 class="text-gray-500 font-medium">Paid Loans</h3>
                <p class="text-3xl font-bold mt-2 text-gray-900">{{ $paidLoans }}</p>
            </div>
        </div>

        <!-- Generate Access Code -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Generate New Access Code</h2>

            @if($codes->count())
                <button disabled
                    class="bg-gray-400 text-white px-6 py-3 rounded-xl shadow-lg font-semibold cursor-not-allowed">
                    Code Already Generated
                </button>
            @else
                <button id="generateCodeBtn" 
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition-transform hover:scale-105">
                    Generate Code
                </button>
            @endif

            <p id="generatedCode" class="mt-3 text-lg font-bold text-indigo-700"></p>
        </div>

        <!-- Access Codes -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Latest Access Codes</h2>

            <div id="codesGrid" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @forelse($codes as $code)
                    <div class="bg-white p-4 rounded-xl shadow-md text-center">
                        <span class="text-indigo-600 font-bold text-xl">{{ $code->code }}</span>
                        <p class="text-gray-400 text-sm mt-1">{{ $code->used ? 'Used' : 'Unused' }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-5">No access codes generated yet.</p>
                @endforelse
            </div>
        </div>
        <!-- Recent Loans Table -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Recent Loans</h2>
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
                            <td class="px-6 py-4">${{ number_format($loan->amount, 2) }}</td>
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
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No recent loans found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- CTA -->
        <div class="mt-10 text-center">
            <a href="{{ route('agent.loans') }}" class="inline-block bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-6 py-3 rounded-xl shadow-lg font-semibold hover:scale-105 transition-transform">
                View All Loans
            </a>
        </div>

    </div>
</div>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('generateCodeBtn');
    const codeEl = document.getElementById('generatedCode');
    const grid = document.getElementById('codesGrid');

    if (!btn) return;

    btn.addEventListener('click', async () => {
        btn.disabled = true;
        btn.textContent = "Generating...";

        try {
            const response = await fetch("{{ route('agent.generateCode') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
            });

            const data = await response.json();

            if (data.success) {
                // New code created
                codeEl.textContent = "Code: " + data.code;
                navigator.clipboard.writeText(data.code);

                // Clear grid and show only this code
                grid.innerHTML = `
                    <div class="bg-white p-4 rounded-xl shadow-md text-center">
                        <span class="text-indigo-600 font-bold text-xl">${data.code}</span>
                        <p class="text-gray-400 text-sm mt-1">Unused</p>
                    </div>
                `;

                alert("Code copied!");

            } else {
                // Existing unused code
                codeEl.textContent = "Existing Code: " + data.code;
                navigator.clipboard.writeText(data.code);

                alert(data.message || "You already have a code.");
            }

        } catch (err) {
            console.error(err);
            alert("Something went wrong!");
        } finally {
            btn.disabled = true; // keep disabled (since now a code exists)
            btn.textContent = "Code Already Generated";
            btn.classList.remove('bg-indigo-500', 'hover:bg-indigo-600');
            btn.classList.add('bg-gray-400', 'cursor-not-allowed');
        }
    });
});
</script>