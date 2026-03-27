<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Load current loan and next-of-kin if exists
        $loan = $user->loan ?? null;
        $nextOfKin = $loan ? $loan->nextOfKin : [];

        return view('onboarding', compact('user', 'loan', 'nextOfKin'));
    }

    public function store(Request $request)
{
    $user = Auth::user();

    // ✅ Validate request
    $validated = $request->validate([
        'employment_status' => 'required|in:employed,unemployed,business',
        'income_range' => 'required|in:25000,35000-50000,51000-99000',
        'loan_amount' => 'nullable|numeric|min:500', // allow null → default applied
        'pay_day' => 'required|date_format:Y-m-d',
        'nok.*.name' => 'required|string|max:255',
        'nok.*.phone' => 'required|string|max:20',
        'nok.*.relation' => 'required|string|in:brother,sister,spouse,parent',
    ]);

    // ✅ Map income range to numeric
    $incomeMap = [
        '25000' => 25000,
        '35000-50000' => 40000,
        '51000-99000' => 70000,
    ];

    // ✅ Update user profile
    $user->update([
        'employment_status' => $validated['employment_status'],
        'monthly_income' => $incomeMap[$validated['income_range']] ?? 0,
    ]);

    // ✅ Determine loan amount safely
    $loanAmount = $validated['loan_amount'] ?? 500; // default 500 if null

    // ✅ Create or update loan
    $loan = $user->loans()->updateOrCreate(
        ['user_id' => $user->id], // match existing loan
        [
            'amount' => $loanAmount,
            'interest_rate' => 10,               // always set
            'term_days' => 14,
            'due_date' => now()->addDays(14),
            'balance_remaining' => $loanAmount,
            'status' => 'active',
            'disbursed_at' => now(),
        ]
    );

    // ✅ Save Next of Kin safely
    if (!empty($validated['nok'])) {
        $loan->nextOfKin()->delete(); // clear old entries

        foreach ($validated['nok'] as $nok) {
            $loan->nextOfKin()->create([
                'name' => $nok['name'],
                'phone' => $nok['phone'],
                'relation' => $nok['relation'],
            ]);
        }
    }

    // ✅ Redirect to dashboard
    return redirect()->route('dashboard');
}
}