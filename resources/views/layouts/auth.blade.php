<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Boda Quick Loans')</title>

    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#FDF6EC]">

<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

    <!-- LEFT SIDE -->
    <div class="flex flex-col justify-between bg-gradient-to-br from-[#FFF7E6] to-[#FFEFD5] p-6 md:p-12 rounded-b-[40px] md:rounded-r-[40px]">
        
        <div>
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight">
                Boda Quick Loans
            </h1>

            <p class="mt-4 md:mt-6 text-gray-700 text-base md:text-lg max-w-full md:max-w-lg">
                Access fair, fast, and transparent loans designed to empower Boda Boda Drivers.
                Grow your business, manage emergencies, and build financial freedom.
            </p>
        </div>

        <!-- Image -->
        <div class="mt-6 md:mt-10 flex justify-center md:justify-start">
            <img src="{{ asset('images/boda-drivers.png') }}" alt="Boda Boda Drivers" class="w-full max-w-sm md:max-w-md rounded-3xl shadow-xl">
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="flex items-center justify-center px-4 sm:px-6 py-10">

        <div class="w-full max-w-md">

            <!-- LOGO -->
            <div class="mb-6 md:mb-8 text-center">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Boda Quick Loans</h2>
                <p class="text-sm md:text-base text-gray-500">Empowering Boda Boda Drivers</p>
            </div>

            <!-- CARD -->
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100">
                @yield('content')
            </div>

            <!-- FOOTER -->
            <p class="text-center text-xs md:text-sm text-gray-400 mt-6">
                © {{ date('Y') }} Boda Quick Loans
            </p>

        </div>

    </div>

</div>

</body>
</html>