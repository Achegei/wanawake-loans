@extends('layouts.agent')

@section('title', 'Agent Dashboard')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                👋 Welcome, {{ auth()->user()->name }}
            </h1>
            <p class="text-gray-500 mt-1">Here’s your performance overview</p>
        </div>

        <!-- Generate Code -->
        <form method="POST" action="{{ route('agent.generateCode') }}">
            @csrf
            <button class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl shadow hover:bg-emerald-700 transition font-semibold">
                + Generate Access Code
            </button>
        </form>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="p-4 bg-green-100 text-green-800 rounded-xl flex justify-between items-center">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Total Loans</p>
            <h2 class="text-3xl font-bold mt-2">{{ $loansCount }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <p class="text-yellow-500 text-sm">Pending Loans</p>
            <h2 class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingLoans }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <p class="text-green-500 text-sm">Paid Loans</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $paidLoans }}</h2>
        </div>

    </div>

    <!-- RECENT ACCESS CODES -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Recent Access Codes</h2>
        </div>

        @if($codes->count())
            <div class="space-y-3">

                @foreach($codes as $code)
                    <div class="flex items-center justify-between bg-gray-50 px-4 py-3 rounded-xl">

                        <div class="flex items-center gap-3">
                            <span class="font-mono text-lg font-bold text-gray-800">
                                {{ $code->code }}
                            </span>

                            @if($code->used)
                                <span class="text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded-full">
                                    Used
                                </span>
                            @else
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                    Active
                                </span>
                            @endif
                        </div>

                        <!-- COPY BUTTON -->
                        <button onclick="copyToClipboard('{{ $code->code }}')"
                                class="text-sm bg-emerald-600 text-white px-3 py-1.5 rounded-lg hover:bg-emerald-700">
                            Copy
                        </button>

                    </div>
                @endforeach

            </div>
        @else
            <p class="text-gray-500">No codes generated yet.</p>
        @endif

    </div>

    <!-- LOANS TABLE -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Recent Loans</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">

                <thead class="text-gray-500 border-b">
                    <tr>
                        <th class="py-2">Client</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($loans as $loan)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="py-3">
                                {{ $loan->user->name ?? 'N/A' }}
                            </td>

                            <td>
                                KES {{ number_format($loan->amount, 2) }}
                            </td>

                            <td>
                                @if($loan->status === 'paid')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                                        Paid
                                    </span>
                                @elseif($loan->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">
                                        Pending
                                    </span>
                                @elseif($loan->status === 'active')
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                                        Active
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">
                                        Overdue
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $loan->created_at->format('d M Y') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">
                                No loans yet
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

<!-- COPY SCRIPT -->
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text);
    alert('Copied: ' + text);
}
</script>

@endsection