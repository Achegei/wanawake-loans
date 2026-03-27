<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Loan;

class LoanController extends Controller
{
    // Show loan application form
    public function create()
    {
        $user = Auth::user();
        $currentLimit = $user->loan_limit;
        $repaid = $user->repaidAtCurrentLevel();
        $progress = min(100, ($repaid / 3) * 100);

        return view('loan.create', compact('currentLimit', 'repaid', 'progress'));
    }

    // Store new loan
    public function store(Request $request)
    {
        $user = Auth::user();
        $max = $user->loan_limit;

        $request->validate([
            'amount' => 'required|numeric|min:500|max:' . $max,
        ]);

        // Prevent multiple active loans
        $activeLoan = $user->loans()->where('status', 'active')->first();
        if ($activeLoan) {
            return redirect()->route('dashboard')->with('error', 'You already have an active loan.');
        }

        $principal = $request->amount;
        $interest = $principal * 0.10; // 10% interest
        $totalDue = $principal + $interest;

        $loan = new Loan();
        $loan->user_id = $user->id;
        $loan->principal = $principal;
        $loan->interest = $interest;
        $loan->total_due = $totalDue;
        $loan->balance_remaining = $totalDue;
        $loan->status = 'active';
        $loan->disbursed_at = now();
        $loan->due_date = now()->addWeeks(2); // 2 weeks
        $loan->save();

        return redirect()->route('dashboard')->with('success', 'Loan successfully applied!');
    }

    // Pay loan
    public function pay(Request $request)
    {
        $loan = Auth::user()->loans()->where('status', 'active')->first();

        if (!$loan) {
            return redirect()->route('dashboard')->with('error', 'No active loan to pay.');
        }

        $loan->balance_remaining = 0;
        $loan->status = 'paid';
        $loan->save();

        return redirect()->route('dashboard')->with('success', 'Loan successfully paid!');
    }
}