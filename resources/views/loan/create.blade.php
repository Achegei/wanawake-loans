@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-2xl shadow-xl space-y-6">

    {{-- Header --}}
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-800">🚀 Quick Loan</h2>
        <p class="text-gray-500 mt-1">Get instant fuel money & repay tomorrow</p>
    </div>

    {{-- Loan Options --}}
    <form id="loanForm" action="{{ route('loan.store') }}" method="POST" class="space-y-4">
    @csrf

    <div class="grid grid-cols-2 gap-4">

        {{-- Option 100 --}}
        <label class="cursor-pointer block">
            <input type="radio" name="amount" value="100" class="hidden peer" {{ old('amount') == 100 ? 'checked' : '' }}>
            <div class="loan-card p-4 rounded-xl border-2 border-gray-200 transition text-center">
                <p class="text-lg font-bold">KES 100</p>
                <p class="text-sm text-gray-500">Repay</p>
                <p class="text-xl font-bold text-green-600">KES 130</p>

                <div class="mt-3 flex justify-center">
                    <div class="w-12 h-12 rounded-full border-4 border-green-400 flex items-center justify-center text-xs font-bold text-green-600">
                        +30
                    </div>
                </div>
            </div>
        </label>

        {{-- Option 200 --}}
        <label class="cursor-pointer block">
            <input type="radio" name="amount" value="200" class="hidden peer" {{ old('amount') == 200 ? 'checked' : '' }}>

            <div class="loan-card p-4 rounded-xl border-2 border-gray-200 transition text-center">
                <p class="text-lg font-bold">KES 200</p>
                <p class="text-sm text-gray-500">Repay</p>
                <p class="text-xl font-bold text-green-600">KES 250</p>

                <div class="mt-3 flex justify-center">
                    <div class="w-12 h-12 rounded-full border-4 border-green-400 flex items-center justify-center text-xs font-bold text-green-600">
                        +50
                    </div>
                </div>
            </div>
        </label>

    </div>

    {{-- Error --}}
    <p id="selectionError" class="text-red-500 text-sm text-center hidden">
        Please select a loan amount
    </p>

    {{-- Info --}}
    <div class="bg-gray-50 p-3 rounded-lg text-sm text-gray-600 text-center">
        ⏱ Repayment is due <strong>tomorrow</strong><br>
        ⚡ Instant disbursement to M-Pesa
    </div>

    {{-- Agent Code --}}
    <div class="space-y-2">
        <input 
                type="text" 
                name="agent_code"
                value="{{ old('agent_code') }}"
                placeholder="Enter Agent Code"
                oninput="this.value = this.value.toUpperCase()"
                class="w-full border p-3 rounded-xl text-center font-semibold tracking-widest"
                required
            >

        @error('agent_code')
            <p class="text-red-500 text-sm text-center">{{ $message }}</p>
        @enderror
    </div>
    {{-- Submit --}}
    <button id="submitBtn" type="submit"
        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl shadow-md transition">
        Apply Now
    </button>

</form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('label .loan-card'); // ensure we target the div inside label
    const radios = document.querySelectorAll('input[name="amount"]');
    const form = document.getElementById('loanForm');
    const error = document.getElementById('selectionError');
    const btn = document.getElementById('submitBtn');
    const codeInput = document.querySelector('input[name="agent_code"]');

    // Handle card highlight when selecting a radio
    radios.forEach((radio, index) => {
        radio.addEventListener('change', () => {
            // Remove highlight from all cards
            cards.forEach(c => {
                c.classList.remove('border-blue-500', 'bg-blue-50');
            });

            // Highlight selected card
            cards[index].classList.add('border-blue-500', 'bg-blue-50');

            // Hide error if previously shown
            error.classList.add('hidden');
        });
    });

    // Highlight the card for previously selected radio (old value / page reload)
    const selected = document.querySelector('input[name="amount"]:checked');
    if (selected) {
        const index = Array.from(radios).indexOf(selected);
        if (index >= 0) {
            cards[index].classList.add('border-blue-500', 'bg-blue-50');
        }
    }

    // Form submit validation
    form.addEventListener('submit', function(e) {
        const selected = document.querySelector('input[name="amount"]:checked');

        if (!selected) {
            e.preventDefault();
            error.classList.remove('hidden');
            return;
        }

        // Trim spaces and uppercase agent code before submit
        codeInput.value = codeInput.value.trim().toUpperCase();

        // Disable submit button and show processing state
        btn.disabled = true;
        btn.innerText = 'Processing...';
    });
});
</script>
@endsection