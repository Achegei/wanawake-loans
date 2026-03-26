<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Show registration form
    public function show()
    {
        return view('auth.register');
    }

    // Handle registration
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'regex:/^(07|01)\d{8}$/', 'unique:users,phone'],
            'password' => 'required|min:6|confirmed', // requires password_confirmation field
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!$user) {
            return back()->withErrors('Failed to create user. Please try again.');
        }

        // Auto login
        Auth::login($user);

        // Redirect to onboarding step
        return redirect()->route('onboarding.show')->with('success', 'Account created successfully!');
    }
}