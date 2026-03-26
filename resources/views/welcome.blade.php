@extends('layouts.app')
@section('Home', 'Home Page')

@section('content')
<body class="bg-gray-50 font-sans">

    <!-- HERO -->
    <section class="bg-blue-600 text-white py-24">
        <div class="container mx-auto text-center px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Get a Loan in Minutes
            </h1>
            <p class="text-lg md:text-2xl mb-8">
                Quick, simple, and flexible loans designed for you.
            </p>
            <a href="{{route('register')}}" class="bg-yellow-400 text-gray-900 font-bold px-8 py-4 rounded-lg shadow hover:bg-yellow-300 transition">
                Apply Now
            </a>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="py-24">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-12">How It Works</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="font-semibold text-xl mb-4">1. Fill Your Details</h3>
                    <p>Provide basic info like name, income, and loan amount.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="font-semibold text-xl mb-4">2. Get Instant Approval</h3>
                    <p>Our system evaluates your eligibility within seconds.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="font-semibold text-xl mb-4">3. Receive Funds</h3>
                    <p>Approved loans are disbursed directly to your account.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- LOAN CALCULATOR -->
    <section id="apply" class="bg-gray-100 py-24">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-8">Check Your Loan Eligibility</h2>
            <form class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow space-y-4">
                <input type="text" placeholder="Full Name" class="w-full p-4 border rounded-lg">
                <input type="email" placeholder="Email" class="w-full p-4 border rounded-lg">
                <input type="tel" placeholder="Phone Number" class="w-full p-4 border rounded-lg">
                <select class="w-full p-4 border rounded-lg">
                    <option value="">Employment Status</option>
                    <option value="employed">Employed</option>
                    <option value="self_employed">Self Employed</option>
                    <option value="unemployed">Unemployed</option>
                </select>
                <input type="number" placeholder="Estimated Monthly Income (KES)" class="w-full p-4 border rounded-lg">
                <input type="number" placeholder="Loan Amount (KES)" class="w-full p-4 border rounded-lg">
                <button type="submit" class="bg-blue-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Check Eligibility
                </button>
            </form>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-800 text-white py-12 text-center">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Loanify') }}. All rights reserved.</p>
    </footer>
@endsection