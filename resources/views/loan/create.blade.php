@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-8 p-4 bg-white rounded-xl shadow-md">

    <h2 class="text-xl font-bold mb-4">Apply for a New Loan</h2>

    <p class="mb-4 text-gray-600">
        Your current loan limit: <strong>KES {{ number_format($currentLimit) }}</strong>
    </p>

    <div class="mb-4">
        <div class="bg-gray-200 rounded-full h-2 w-full mt-1">
            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progress }}%"></div>
        </div>
        <p class="text-gray-500 text-sm mt-1">
            Repay {{ 3 - $repaid }} more loan(s) at this level to unlock the next limit.
        </p>
    </div>

    <form action="{{ route('loan.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Loan Amount (KES)</label>
            <input type="number" name="amount" value="{{ $currentLimit }}" min="500" max="{{ $currentLimit }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg">
            Apply
        </button>
    </form>

</div>
@endsection