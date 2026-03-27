@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-8 p-4 bg-white rounded-xl shadow-md space-y-6">

    <div class="text-center">
        <h1 class="text-2xl font-bold">Welcome, {{ auth()->user()->name }} 👋</h1>
        <p class="text-gray-500 mt-1">Here’s your loan summary</p>
    </div>

    {{-- Current Loan --}}
    @if($loan)
        @php
            $principal = $loan->principal;
            $interest = $loan->interest;
            $totalDue = $loan->balance_remaining;
            $due = $loan->due_date ? \Carbon\Carbon::parse($loan->due_date) : null;
            $now = now();
            $daysLeft = ($loan->status !== 'paid' && $due) ? $due->diffInDays($now, false) : null;

            $statusColor = $loan->status === 'paid' ? 'text-green-600'
                         : ($daysLeft !== null && $daysLeft < 0 ? 'text-red-600' : 'text-blue-600');
        @endphp

        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200 space-y-3">
            
            <div class="flex justify-between items-center">
                <span class="font-semibold">Loan Status:</span>
                <span class="font-bold {{ $statusColor }}">{{ ucfirst($loan->status) }}</span>
            </div>

            <div class="flex justify-between">
                <span>Disbursed:</span>
                <span>{{ $loan->disbursed_at ? $loan->disbursed_at->format('d M Y') : 'N/A' }}</span>
            </div>

            <div class="flex justify-between">
                <span>Principal:</span>
                <span>KES {{ number_format($principal, 2) }}</span>
            </div>

            <div class="flex justify-between">
                <span>Interest:</span>
                <span>KES {{ number_format($interest, 2) }}</span>
            </div>

            <div class="flex justify-between font-bold text-lg">
                <span>Total {{ $loan->status === 'paid' ? 'Paid' : 'Due' }}:</span>
                <span>KES {{ number_format($totalDue, 2) }}</span>
            </div>

            <div class="flex justify-between items-center">
                <span>Due Date:</span>
                <span>{{ $due ? $due->format('d M Y') : 'N/A' }}</span>
            </div>

            @if($daysLeft !== null)
                <div class="mt-2 text-center font-semibold {{ $daysLeft < 0 ? 'text-red-600' : 'text-green-600' }}">
                    @if($daysLeft >= 0)
                        {{ $daysLeft }} {{ Str::plural('day', $daysLeft) }} left
                    @else
                        Overdue by {{ abs($daysLeft) }} {{ Str::plural('day', abs($daysLeft)) }}
                    @endif
                </div>
            @endif

            <div class="mt-4 text-center">
                @if($loan->status !== 'paid')
                    <form action="{{ route('loan.pay') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                            Pay with M-Pesa
                        </button>
                    </form>
                @elseif($canApply)
                    <a href="{{ route('loan.apply') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                        Apply for New Loan
                    </a>
                @endif
            </div>
        </div>
    @else
        <div class="p-4 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200 text-center">
            <p>No active loan yet. Complete onboarding to get started.</p>
        </div>
    @endif

    {{-- Loan Limit Progress --}}
    <div class="mt-4">
        <p>Your current loan limit: <strong>KES {{ number_format($currentLimit) }}</strong></p>
        <div class="bg-gray-200 rounded-full h-2 w-full mt-1">
            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progress }}%"></div>
        </div>
        <p class="text-gray-500 text-sm mt-1">
            Repay {{ 3 - $repaid }} more loan(s) at this level to unlock the next limit.
        </p>
    </div>

</div>
@endsection