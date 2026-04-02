<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('agents.auth.login'); // create a separate view
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        // Only allow users with is_agent = 1
        if (Auth::attempt(array_merge($credentials, ['is_agent' => 1]))) {
            $request->session()->regenerate();
            return redirect()->intended('/agent/dashboard');
        }

        return back()->withErrors([
            'phone' => 'Invalid credentials or not an agent',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/agent/login');
    }
}