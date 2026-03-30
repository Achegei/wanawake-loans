<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NextOfKin;

class OnboardingController extends Controller
{
        public function show()
    {
        $user = Auth::user();

        // ✅ Skip if already onboarded
        if ($user->is_onboarded) {
            return redirect()->route('dashboard');
        }

        // ✅ Load user's next of kin directly
        $nextOfKin = $user->nextOfKin ?? [];

        return view('onboarding', compact('user', 'nextOfKin'));
    }

   public function store(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'employment_status' => 'required|in:employed,unemployed,business',
        'income_range' => 'required|in:25000,35000-50000,51000-99000',
        'pay_day' => 'required|date_format:Y-m-d',
        'nok.*.name' => 'required|string|max:255',
        'nok.*.phone' => 'required|string|max:20',
        'nok.*.relation' => 'required|string|in:brother,sister,spouse,parent',
    ]);

    $incomeMap = [
        '25000' => 25000,
        '35000-50000' => 40000,
        '51000-99000' => 70000,
    ];

    // ✅ Update user
    $user->update([
        'employment_status' => $validated['employment_status'],
        'monthly_income' => $incomeMap[$validated['income_range']] ?? 0,
        'is_onboarded' => true,
    ]);

    // ✅ Save Next of Kin (USER LEVEL)
    $user->nextOfKin()->delete();

    foreach ($validated['nok'] as $nok) {
        $user->nextOfKin()->create($nok);
    }

    return redirect()->route('dashboard');
}
}