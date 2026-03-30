<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function show()
    {
        return view('auth.login');
    }

    // Handle login
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 1️⃣ Admin check
            if ($user->is_admin) {
                return redirect('/admin/dashboard');
            }

            // 2️⃣ Check onboarding flag
            if (!$user->is_onboarded) {
                return redirect()->route('onboarding.show');
            }

            // 3️⃣ Fetch latest loan
            $loan = $user->loans()->latest()->first();

            // 4️⃣ No loan → still onboarded but no loan yet
            if (!$loan) {
                return redirect()->route('dashboard');
            }

            // 5️⃣ Loan exists but not disbursed yet
            if (!$loan->disbursed_at) {
                return redirect()->route('dashboard');
            }

            // 6️⃣ Loan active → dashboard
            if ($loan->status === 'active') {
                return redirect()->route('dashboard');
            }

            // 7️⃣ Loan paid → dashboard (user can apply again if allowed)
            if ($loan->status === 'paid') {
                return redirect()->route('dashboard');
            }

            // fallback
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'phone' => 'Invalid credentials',
        ]);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}