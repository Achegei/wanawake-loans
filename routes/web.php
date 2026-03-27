<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

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
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pay loan (M-Pesa integration)
    Route::post('/loan/pay', [LoanController::class, 'pay'])->name('loan.pay');

    // Apply for a new loan (only for fully paid loans)
    Route::get('/loan/apply', [LoanController::class, 'create'])->name('loan.apply');
    Route::post('/loan/apply', [LoanController::class, 'store'])->name('loan.store');
});