<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wanawake Loans')</title>

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
    <div class="hidden md:flex flex-col justify-between bg-gradient-to-br from-amber-100 to-amber-200 p-12 rounded-r-[40px]">

        <div>
            <h1 class="text-5xl font-extrabold text-gray-900 leading-tight">
                Take control of your finances with Wanawake Loans
            </h1>

            <p class="mt-6 text-gray-700 text-lg max-w-lg">
                Access fair, fast, and transparent loans designed to empower women.
                Grow your business, manage emergencies, and build financial freedom.
            </p>
        </div>

        <!-- Image -->
        <div class="mt-10">
            <img src="/images/women-finance.png" alt="Women Empowerment" class="rounded-3xl shadow-xl">
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="flex items-center justify-center px-6 py-10">

        <div class="w-full max-w-md">

            <!-- LOGO -->
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900">Wanawake Loans</h2>
                <p class="text-sm text-gray-500">Empowering women financially</p>
            </div>

            <!-- CARD -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">

                @yield('content')

            </div>

            <!-- FOOTER -->
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} Wanawake Loans
            </p>

        </div>

    </div>

</div>

</body>
</html>