<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->is_onboarded) {
            return redirect()->route('dashboard');
        }

        return view('onboarding', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user->update(['is_onboarded' => true]);

        return redirect()->route('dashboard')
            ->with('success', 'Welcome! You can now request a loan.');
    }
}