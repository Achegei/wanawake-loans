@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-12 bg-cream p-8 rounded-2xl shadow-lg">
    <h1 class="text-3xl font-bold mb-6">Set Up Your Loan Profile</h1>

    <form action="{{ route('onboarding.store') }}" method="POST">
        @csrf

        <!-- Employment Status -->
        <div class="mb-4">
            <label class="block font-semibold">Employment Status</label>
            <select name="employment_status" class="border p-2 w-full rounded" required>
                <option value="">Select</option>
                <option value="employed">Employed</option>
                <option value="unemployed">Unemployed</option>
                <option value="business">Business</option>
            </select>
        </div>

        <!-- Income Range -->
        <div class="mb-4">
            <label class="block font-semibold">Estimated Monthly Income</label>
            <select name="income_range" class="border p-2 w-full rounded" required>
                <option value="">Select</option>
                <option value="25000">KES 25,000 and below</option>
                <option value="35000-50000">KES 35,000 – 50,000</option>
                <option value="51000-99000">KES 51,000 – 99,000</option>
            </select>
        </div>

        <!-- Loan Amount -->
        <div class="mb-4">
            <label class="block font-semibold">Loan Amount</label>
            <input type="number" name="loan_amount" value="500" class="border p-2 w-full rounded" readonly>
            <small class="text-gray-500">Your starting limit is KES 500. Prompt repayment increases your limit automatically.</small>
        </div>

        <!-- Pay Day -->
        <div class="mb-4">
            <label class="block font-semibold">Preferred Pay Day</label>
            <input type="date" name="pay_day" class="border p-2 w-full rounded" required>
        </div>

        <!-- Next of Kin -->
        <div class="mb-6">
            <label class="block font-semibold mb-2">Next of Kin</label>

            @for ($i = 0; $i < 2; $i++)
            <div class="mb-4 p-4 border rounded">
                <h3 class="font-semibold mb-2">Contact {{ $i + 1 }}</h3>

                <input type="text" name="nok[{{ $i }}][name]" placeholder="Full Name" class="border p-2 w-full rounded mb-2" required>

                <input type="text" name="nok[{{ $i }}][phone]" placeholder="Phone Number" class="border p-2 w-full rounded mb-2" required>

                <select name="nok[{{ $i }}][relation]" class="border p-2 w-full rounded" required>
                    <option value="">Select Relation</option>
                    <option value="brother">Brother</option>
                    <option value="sister">Sister</option>
                    <option value="spouse">Spouse</option>
                    <option value="parent">Parent</option>
                </select>
            </div>
            @endfor
        </div>

        <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded hover:bg-blue-700">
            Continue
        </button>
    </form>
</div>
@endsection