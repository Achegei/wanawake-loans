@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 space-y-6">

    {{-- Header --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-800">👋 Welcome, {{ $user->name }}</h1>
        <p class="text-gray-500">Your financial snapshot</p>
    </div>

    {{-- Loan Card --}}
    @if($loan)
        <div class="bg-white p-6 rounded-2xl shadow-xl space-y-4 border">

            {{-- Status Badge --}}
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">Loan Status</span>
                <span class="px-3 py-1 text-sm rounded-full
                    {{ $loan->status === 'paid' ? 'bg-green-100 text-green-600' : 
                       ($loan->status === 'pending' ? 'bg-yellow-100 text-yellow-600' :
                       ($loan->isOverdue ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600')) }}">
                    {{ ucfirst($loan->status) }}
                </span>
            </div>

            {{-- Total Due --}}
            <div class="flex justify-center">
                <div class="w-28 h-28 rounded-full border-4 border-blue-400 flex flex-col items-center justify-center shadow-inner">
                    <span class="text-sm text-gray-500">Total Due</span>
                    <span class="text-xl font-bold text-gray-800">
                        {{ number_format($loan->totalDue, 2) }}
                    </span>
                </div>
            </div>

            {{-- Breakdown --}}
            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <p>Principal</p>
                    <p class="font-bold text-gray-800">{{ number_format($loan->principal, 2) }}</p>
                </div>
                <div>
                    <p>Interest</p>
                    <p class="font-bold text-green-600">{{ number_format($loan->interestAmount, 2) }}</p>
                </div>
            </div>

            {{-- Balance Remaining --}}
            <div class="text-center">
                <p class="text-sm text-gray-500">Balance Remaining</p>
                <p class="font-bold text-gray-800">{{ number_format($loan->balance_remaining, 2) }}</p>
            </div>

            {{-- Due Info --}}
            @if(in_array($loan->status, ['pending', 'active']))
                <div class="text-center">
                    <p class="text-gray-500 text-sm">Due Date</p>
                    <p class="font-semibold">{{ $loan->due_date->format('d M Y, h:i A') }}</p>

                    @php
                        $now = now();
                        $minutesLeft = $loan->due_date->diffInMinutes($now, false);
                        $hoursLeft = ceil($minutesLeft / 60); // round up partial hours
                        $isOverdue = $hoursLeft < 0;
                    @endphp

                    <p class="mt-1 font-bold {{ $isOverdue ? 'text-red-600' : 'text-green-600' }}">
                        @if(!$isOverdue)
                            {{ $hoursLeft }} hour(s) left
                        @else
                            Overdue by {{ abs($hoursLeft) }} hour(s)
                        @endif
                    </p>
                </div>
            @endif

            {{-- Actions --}}
            <div class="text-center pt-2">
                @if($loan->status === 'active')
                    <form action="{{ route('loan.pay') }}" method="POST">
                        @csrf
                        <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold shadow-md">
                            💳 Pay with M-Pesa
                        </button>
                    </form>
                @elseif($loan->status === 'paid' && $canApply)
                    <a href="{{ route('loan.apply') }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-xl font-bold shadow-md">
                        🚀 Take Another Loan
                    </a>
                @endif
            </div>

        </div>
    @else
        {{-- No loan --}}
        <div class="bg-white p-6 rounded-2xl shadow-xl text-center space-y-4">
            <p class="text-gray-600">No active loan</p>
            @if($canApply)
                <a href="{{ route('loan.apply') }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-xl font-bold shadow-md">
                    🚀 Apply for Loan
                </a>
            @endif
        </div>
    @endif

</div>
@endsection