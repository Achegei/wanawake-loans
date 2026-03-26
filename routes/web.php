<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OnboardingController;

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard (protected)
Route::get('/dashboard', function () {
    return "User Dashboard";
})->middleware('auth')->name('dashboard');

Route::get('/admin/dashboard', function () {
    return "Admin Dashboard";
})->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding.show');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
});