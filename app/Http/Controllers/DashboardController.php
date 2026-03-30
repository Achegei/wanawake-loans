<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch one loan:
        // Priority: pending > active > latest paid
        $loan = $user->loans()
                     ->whereIn('status', ['pending', 'active'])
                     ->latest()
                     ->first();

        if (!$loan) {
            $loan = $user->loans()->latest()->first();
        }

        if ($loan) {
            $loan->daysLeft = $loan->days_left;          // computed in model
            $loan->isOverdue = $loan->isOverdue();      // boolean
        }

        $canApply = !$loan || $loan->status === 'paid';

        return view('dashboard', compact('user', 'loan', 'canApply'));
    }
}