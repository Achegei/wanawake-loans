@extends('layouts.app')
@section('Home', 'Home Page')
<!-- Animations -->
<style>
@keyframes fadeInDown {
  0% { opacity: 0; transform: translateY(-20px); }
  100% { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}
@keyframes pulseSlow {
  0%, 100% { transform: scale(1); opacity: 1; }
  50% { transform: scale(1.05); opacity: 0.9; }
}
@keyframes slideInLeft {
  0% { opacity: 0; transform: translateX(-100px); }
  100% { opacity: 1; transform: translateX(0); }
}
@keyframes moneyFlow {
  0% { transform: translateY(0) rotate(0deg); opacity: 1; }
  100% { transform: translateY(-200px) rotate(360deg); opacity: 0; }
}
.animate-fadeInDown { animation: fadeInDown 1s ease forwards; }
.animate-fadeInUp { animation: fadeInUp 1s ease forwards; animation-delay: 0.3s; }
.animate-pulse-slow { animation: pulseSlow 3s ease-in-out infinite; }
.animate-slideInLeft { animation: slideInLeft 1.2s ease forwards; }
.animate-moneyFlow { animation: moneyFlow 2s linear infinite; }
.animate-moneyFlow.delay-200 { animation-delay: 0.2s; }
.animate-moneyFlow.delay-400 { animation-delay: 0.4s; }
</style>

@section('content')
<body class="bg-gray-50 font-sans">

<!-- HERO -->
<section class="relative overflow-hidden py-24 bg-indigo-50">
    <!-- Animated Background Circles -->
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-100 rounded-full opacity-30 animate-pulse-slow"></div>
    <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-yellow-200 rounded-full opacity-30 animate-pulse-slow"></div>

    <div class="container mx-auto text-center px-4 max-w-3xl relative z-10">

        <!-- Sliding Moto Icon -->
        <div class="absolute left-0 top-1/3 w-20 h-20 animate-slideInLeft">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-full h-full">
            <!-- Wheels -->
            <circle cx="16" cy="48" r="8" fill="#4F46E5" />
            <circle cx="48" cy="48" r="8" fill="#4F46E5" />

            <!-- Motorcycle Body -->
            <path d="M12 48 L20 32 L44 32 L52 48 Z" fill="#10B981" />
            
            <!-- Seat & Handlebar -->
            <rect x="20" y="28" width="24" height="4" fill="#4F46E5" />
            <line x1="44" y1="28" x2="50" y2="24" stroke="#FACC15" stroke-width="2" />
            
            <!-- Optional Motion Lines -->
            <line x1="52" y1="44" x2="60" y2="40" stroke="#F59E0B" stroke-width="2" stroke-linecap="round"/>
            <line x1="52" y1="48" x2="60" y2="44" stroke="#F59E0B" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>

        <!-- Heading with gradient & glow -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 via-green-500 to-yellow-400 animate-fadeInDown drop-shadow-xl">
            Asking No More to Fuel Your Bike? 🔥
        </h1>

        <!-- Paragraph with fade in -->
        <p class="text-lg md:text-2xl mb-8 text-gray-700 animate-fadeInUp">
            Tube burst? Brake failed? Emergency garage need with no cash? <br>
            Instead of borrowing from people <em>cheza chini</em>, we got you covered – <em>cheza kiwewe</em>!  
            Apply for a quick loan and repay within the day.
        </p>

        <!-- Money Flow behind button -->
        <div class="relative inline-block">
            <!-- Coins/Bills Animation -->
            <div class="absolute inset-0 flex justify-center pointer-events-none overflow-hidden">
                <div class="animate-moneyFlow absolute w-4 h-4 bg-yellow-400 rounded-full"></div>
                <div class="animate-moneyFlow absolute w-3 h-3 bg-green-400 rounded-full delay-200"></div>
                <div class="animate-moneyFlow absolute w-5 h-5 bg-indigo-400 rounded-full delay-400"></div>
            </div>

            <!-- Apply Button -->
            <a href="#loan-options"
               class="relative inline-block bg-indigo-500 text-white font-bold px-10 py-4 rounded-2xl shadow-2xl hover:bg-indigo-600 transform hover:-translate-y-1 transition-all animate-pulse-slow">
                Apply Now
            </a>
        </div>
    </div>
</section>

<!-- LOAN OPTIONS -->
<section id="loan-options" class="py-20">
    <div class="container mx-auto px-4 text-center max-w-3xl">
        <h2 class="text-3xl font-bold mb-10">Choose Your Loan</h2>
        
        <form id="loanForm" action="{{ route('loan.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            {{-- Loan 100 --}}
            <label class="cursor-pointer block">
                <input type="radio" name="amount" value="100" class="hidden peer">
                <div class="loan-card p-6 rounded-2xl border-2 border-gray-200 transition text-center hover:shadow-xl hover:border-indigo-500">
                    <p class="text-xl font-bold">KES 100</p>
                    <p class="text-sm text-gray-500 mt-1">Repay same day</p>
                    <p class="text-2xl font-extrabold text-green-600 mt-2">KES 130</p>
                    <div class="mt-4 flex justify-center">
                        <div class="w-12 h-12 rounded-full border-4 border-green-400 flex items-center justify-center text-sm font-bold text-green-600">
                            +30
                        </div>
                    </div>
                </div>
            </label>

            {{-- Loan 200 --}}
            <label class="cursor-pointer block">
                <input type="radio" name="amount" value="200" class="hidden peer">
                <div class="loan-card p-6 rounded-2xl border-2 border-gray-200 transition text-center hover:shadow-xl hover:border-indigo-500">
                    <p class="text-xl font-bold">KES 200</p>
                    <p class="text-sm text-gray-500 mt-1">Repay same day</p>
                    <p class="text-2xl font-extrabold text-green-600 mt-2">KES 250</p>
                    <div class="mt-4 flex justify-center">
                        <div class="w-12 h-12 rounded-full border-4 border-green-400 flex items-center justify-center text-sm font-bold text-green-600">
                            +50
                        </div>
                    </div>
                </div>
            </label>

            {{-- Error --}}
            <p id="selectionError" class="text-red-500 text-sm text-center col-span-full hidden mt-2">
                Please select a loan amount
            </p>

            {{-- Submit Button --}}
            <button id="submitBtn" type="submit"
                class="col-span-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-4 rounded-2xl shadow-lg transition mt-4">
                Apply Now
            </button>
        </form>

        {{-- Info --}}
        <div class="bg-gray-100 p-4 rounded-xl text-gray-700 text-sm mt-6">
            ⚡ Instant cash to M-Pesa | ⏱ Repay within the same day
        </div>
    </div>
</section>
<!-- LOAN PROCESS -->
<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4 text-center max-w-5xl">
        <h2 class="text-3xl font-bold mb-12">How the Loan Works</h2>
        <div class="grid md:grid-cols-4 gap-8">

            <!-- Step 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition">
                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-indigo-500 text-white font-bold text-xl rounded-full">
                    1
                </div>
                <h3 class="text-xl font-semibold mb-2">Click Apply</h3>
                <p class="text-gray-600 text-sm">Go to the registration page and start your application.</p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition">
                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-indigo-500 text-white font-bold text-xl rounded-full">
                    2
                </div>
                <h3 class="text-xl font-semibold mb-2">Choose Amount</h3>
                <p class="text-gray-600 text-sm">Select KES 100 or KES 200 and click “Apply Loan”.</p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition">
                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-green-500 text-white font-bold text-xl rounded-full">
                    3
                </div>
                <h3 class="text-xl font-semibold mb-2">Instant Disbursement</h3>
                <p class="text-gray-600 text-sm">Your loan is sent to your phone in less than a minute via M-Pesa.</p>
            </div>

            <!-- Step 4 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition">
                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-yellow-400 text-white font-bold text-xl rounded-full">
                    4
                </div>
                <h3 class="text-xl font-semibold mb-2">Repay Easily</h3>
                <p class="text-gray-600 text-sm">Click “Pay with M-Pesa”, complete the STK push, enter your PIN, and your loan is successfully repaid.</p>
            </div>

        </div>
    </div>
</section>

<!-- GAMIFICATION METRICS -->
<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4 text-center max-w-5xl">
        <h2 class="text-3xl font-bold mb-12">Our Impact So Far</h2>
        <div class="grid md:grid-cols-3 gap-8">

            <!-- Active Riders -->
            <div class="bg-white rounded-full w-40 h-40 flex flex-col items-center justify-center mx-auto shadow-lg">
                <p class="text-4xl font-extrabold text-indigo-600 counter" data-target="1200">0</p>
                <p class="text-gray-600 mt-2 text-center">Active Riders</p>
            </div>

            <!-- Loans Disbursed -->
            <div class="bg-white rounded-full w-40 h-40 flex flex-col items-center justify-center mx-auto shadow-lg">
                <p class="text-4xl font-extrabold text-green-500 counter" data-target="5400">0</p>
                <p class="text-gray-600 mt-2 text-center">Loans Disbursed</p>
            </div>

            <!-- Cash Circulated -->
            <div class="bg-white rounded-full w-40 h-40 flex flex-col items-center justify-center mx-auto shadow-lg">
                <p class="text-4xl font-extrabold text-yellow-500 counter" data-target="3450000">0</p>
                <p class="text-gray-600 mt-2 text-center">KES Circulated</p>
            </div>

        </div>
    </div>
</section>

<!-- BENEFITS -->
<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4 text-center max-w-4xl">
        <h2 class="text-3xl font-bold mb-12">Why Riders Love Us</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition">
                <h3 class="text-xl font-semibold mb-4">Fast Cash</h3>
                <p>Get instant disbursement directly to your M-Pesa account.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition">
                <h3 class="text-xl font-semibold mb-4">Flexible Repayment</h3>
                <p>Repay within the same day – no unnecessary delays or penalties.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition">
                <h3 class="text-xl font-semibold mb-4">Simple & Transparent</h3>
                <p>Clear repayment amounts and no hidden charges.</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // Loan Card Selection Logic
    // =========================
    const cards = document.querySelectorAll('.loan-card');
    const radios = document.querySelectorAll('input[name="amount"]');
    const form = document.getElementById('loanForm');
    const error = document.getElementById('selectionError');
    const btn = document.getElementById('submitBtn');

    radios.forEach((radio, index) => {
        radio.addEventListener('change', () => {
            cards.forEach(c => c.classList.remove('border-indigo-500','bg-indigo-50'));
            cards[index].classList.add('border-indigo-500','bg-indigo-50');
            error.classList.add('hidden');
        });
    });

    form.addEventListener('submit', function(e) {
        const selected = document.querySelector('input[name="amount"]:checked');
        if(!selected){
            e.preventDefault();
            error.classList.remove('hidden');
            return;
        }
        btn.disabled = true;
        btn.innerText = 'Processing...';
    });

    // =========================
    // Gamification Counters Logic
    // =========================
    const counters = document.querySelectorAll('.counter');

    const formatNumber = (num) => {
        if(num >= 1000000){
            return (num / 1000000).toFixed(2) + 'M';
        } else if(num >= 1000){
            return (num / 1000).toFixed(1) + 'K';
        } else {
            return num.toLocaleString();
        }
    };

    counters.forEach(counter => {
        let count = 0;
        const target = +counter.getAttribute('data-target');

        const updateCount = () => {
            const increment = Math.ceil(target / 200); // speed of counting
            count += increment;

            if(count < target){
                counter.innerText = formatNumber(count);
                requestAnimationFrame(updateCount); // smoother animation
            } else {
                counter.innerText = formatNumber(target);
            }
        };

        updateCount();
    });

});
</script>
</body>
@endsection