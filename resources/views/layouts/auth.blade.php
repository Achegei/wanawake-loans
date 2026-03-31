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

<div class="min-h-screen grid md:grid-cols-2">

    <!-- LEFT SIDE -->
    <div class="hidden md:flex flex-col justify-between bg-gradient-to-br from-[#FFF7E6] to-[#FFEFD5] p-12 rounded-r-[40px]">

        <div>
            <h1 class="text-5xl font-extrabold text-gray-900 leading-tight">
                Boda Quick Loans
            </h1>

            <p class="mt-6 text-gray-700 text-lg max-w-lg">
                Access fair, fast, and transparent loans designed to empower Boda Boda Drivers.
                Grow your business, manage emergencies, and build financial freedom.
            </p>
        </div>

        <!-- Image -->
        <div class="mt-10">
            <img src="{{ asset('images/boda-drivers.png') }}" alt="Boda Boda Drivers" class="rounded-3xl shadow-xl">
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="flex items-center justify-center px-6 py-10">

        <div class="w-full max-w-md">

            <!-- LOGO -->
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900">Boda Quick Loans</h2>
                <p class="text-sm text-gray-500">Empowering Boda Boda Drivers</p>
            </div>

            <!-- CARD -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">

                @yield('content')

            </div>

            <!-- FOOTER -->
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} Boda Quick Loans
            </p>

        </div>

    </div>

</div>

</body>
</html>