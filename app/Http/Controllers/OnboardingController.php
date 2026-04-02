<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesAgent;

class OnboardingController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Skip if already onboarded
        if ($user->is_onboarded) {
            return redirect()->route('dashboard');
        }

        return view('onboarding', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // ✅ ONLY agent code now
        $validated = $request->validate([
            'agent_code' => 'required|string',
        ]);

        // ✅ Find agent
        $agent = SalesAgent::where('code', strtoupper($validated['agent_code']))->first();

        if (!$agent) {
            return back()
                ->withErrors(['agent_code' => 'Invalid sales agent code'])
                ->withInput();
        }

        // ✅ Update user
        $user->update([
            'is_onboarded' => true,
            'sales_agent_id' => $agent->id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Welcome! You can now request a loan.');
    }
}