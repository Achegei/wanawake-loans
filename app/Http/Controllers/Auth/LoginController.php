<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function store(Request $request)
{
    $credentials = $request->validate([
        'phone' => 'required',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Admin check
        if ($user->is_admin) {
            return redirect('/admin/dashboard');
        }

        // 🔥 CORE LOGIC STARTS HERE

        // 1. No loan at all → go to onboarding
        if (!$user->loan) {
            return redirect()->route('onboarding.show');
        }

        // 2. Has loan but NOT disbursed → still onboarding stage
        if (!$user->loan->disbursed_at) {
            return redirect()->route('onboarding.show');
        }

        // 3. Loan active → go dashboard
        if ($user->loan->status === 'active') {
            return redirect()->route('dashboard');
        }

        // 4. Loan cleared → allow re-application later (optional)
        if ($user->loan->status === 'paid') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'phone' => 'Invalid credentials',
    ]);
}
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}