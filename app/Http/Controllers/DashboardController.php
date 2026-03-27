<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $loan = $user->loans()->latest()->first();

        $canApply = !$loan || $loan->status === 'paid';
        $currentLimit = $user->loan_limit;
        $repaid = $user->repaidAtCurrentLevel();
        $progress = min(100, ($repaid / 3) * 100);

        return view('dashboard', compact('loan', 'canApply', 'currentLimit', 'repaid', 'progress'));
    }
}