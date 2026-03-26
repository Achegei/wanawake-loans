<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoanNextOfKin;

class OnboardingController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Load current loan and next-of-kin progress if exists
        $loan = $user->loan ?? null;
        $nextOfKin = $loan ? $loan->nextOfKin : [];

        return view('onboarding', compact('user', 'loan', 'nextOfKin'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate loan and next-of-kin data
        $validated = $request->validate([
            'employment_status' => 'required|in:employed,unemployed,business',
            'income_range' => 'required|in:25000,35000-50000,51000-99000',
            'loan_amount' => 'required|numeric|min:500',
            'pay_day' => 'required|date_format:Y-m-d',
            'nok.*.name' => 'required|string|max:255',
            'nok.*.phone' => 'required|string|max:20',
            'nok.*.relation' => 'required|string|in:brother,sister,spouse,parent',
        ]);

        // Create or update user loan
        $loan = $user->loan()->updateOrCreate(
            [],
            [
                'employment_status' => $validated['employment_status'],
                'income_range' => $validated['income_range'],
                'loan_amount' => $validated['loan_amount'],
                'pay_day' => $validated['pay_day'],
                'current_limit' => 500, // default starting limit
                'repayments_done' => 0
            ]
        );

        // Update next-of-kin contacts
        $loan->nextOfKin()->delete(); // Remove old entries if any
        foreach ($validated['nok'] as $nok) {
            $loan->nextOfKin()->create($nok);
        }

        return redirect()->route('dashboard'); // or next step
    }
}