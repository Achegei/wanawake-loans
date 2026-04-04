@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-12 bg-white p-6 rounded-2xl shadow-lg">

    <h1 class="text-2xl font-bold mb-2 text-center">
        Enter Agent Code
    </h1>

    <p class="text-gray-500 text-sm text-center mb-6">
        Get a code from your sales agent to continue
    </p>

    <!-- Errors -->
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('onboarding.store') }}">
    @csrf

    <button class="w-full bg-blue-500 text-white py-3 rounded-xl">
        Continue
    </button>
</form>

</div>
@endsection