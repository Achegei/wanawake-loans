<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SalesAgentController as AdminSalesAgentController;

// Agent Controller
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\AgentLoginController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Landing
Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Onboarding
    Route::prefix('onboarding')->group(function () {
        Route::get('/', [OnboardingController::class, 'show'])->name('onboarding.show');
        Route::post('/', [OnboardingController::class, 'store'])->name('onboarding.store');
    });

    // Loans
    Route::prefix('loan')->group(function () {
        Route::get('/apply', [LoanController::class, 'create'])->name('loan.apply');
        Route::post('/apply', [LoanController::class, 'store'])->name('loan.store');
        Route::post('/pay', [LoanController::class, 'pay'])->name('loan.pay');
    });

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |---------------------------
    | Admin Auth (Guest)
    |---------------------------
    */
    Route::middleware('guest.admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    });

    /*
    |---------------------------
    | Admin Logout
    |---------------------------
    */
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    /*
    |---------------------------
    | Protected Admin Area
    |---------------------------
    */
    Route::middleware(['auth.admin'])->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        /*
        |---------------------------
        | SALES AGENTS (ADMIN ONLY)
        |---------------------------
        */
        Route::prefix('agents')->name('agents.')->group(function () {

            Route::get('/', [AdminSalesAgentController::class, 'index'])->name('index');
            Route::get('/create', [AdminSalesAgentController::class, 'create'])->name('create');
            Route::post('/', [AdminSalesAgentController::class, 'store'])->name('store'); // ✅ FIXED (no /store)
            Route::get('/{agent}/edit', [AdminSalesAgentController::class, 'edit'])->name('edit');
            Route::put('/{agent}', [AdminSalesAgentController::class, 'update'])->name('update');

            Route::post('/{agent}/generate-code', [AdminSalesAgentController::class, 'generateAccessCode'])
                ->name('generateCode');

            Route::get('/{agent}/loans', [AdminSalesAgentController::class, 'loans'])
                ->name('loans');
        });

    });
});


/*
|--------------------------------------------------------------------------
| AGENT LOGIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('agent')->name('agent.')->group(function () {

    // Guest Agent Login
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AgentLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AgentLoginController::class, 'login'])->name('login.submit');
    });

    // Authenticated Agent Routes
    Route::middleware(['auth', 'auth.agent'])->group(function () {
        Route::get('/dashboard', [AgentDashboardController::class, 'index'])->name('dashboard');
        Route::post('/generate-code', [AgentDashboardController::class, 'generateCode'])->name('generateCode');
        Route::get('/loans', [AgentDashboardController::class, 'loans'])->name('loans');
        Route::post('/logout', [AgentLoginController::class, 'logout'])->name('logout');
    });
});

// IntaSend Webhook Endpoint
Route::post('/webhooks/intasend', function (\Illuminate\Http\Request $request) {

    \Log::info('IntaSend Webhook:', $request->all());

    $invoiceId = $request->invoice_id ?? null;
    $state = $request->state ?? null;

    if ($invoiceId && $state === 'COMPLETE') {

        $loan = \App\Models\Loan::where('transaction_id', $invoiceId)->first();

        if ($loan) {
            $loan->update([
                'status' => 'paid',
                'balance_remaining' => 0
            ]);

            \Log::info('Loan marked as PAID', ['loan_id' => $loan->id]);
        }
    }

    return response()->json(['status' => 'ok']);
});