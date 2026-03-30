<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Loan;
use App\Jobs\DisburseLoanJob;

class LoanController extends Controller
{
    /**
     * Show loan application form
     */
    public function create()
    {
        $allowedAmounts = [100, 200]; // Extendable
        return view('loan.create', compact('allowedAmounts'));
    }

    /**
     * Store a new loan and queue disbursement
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $request->validate([
            'amount' => 'required|in:100,200',
        ]);

        // Prevent any ongoing loans
        $hasExistingLoan = $user->loans()
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($hasExistingLoan) {
            return redirect()->route('dashboard')
                ->with('error', 'You already have an ongoing loan.');
        }

        // Business logic: interest & term
        $principal = $request->amount;
        $interest = $principal == 100 ? 30 : 50; // Fixed interest
        $termDays = 1;
        $totalDue = $principal + $interest;

        DB::beginTransaction();

        try {
            // Create loan record
            $loan = $user->loans()->create([
    'amount' => $principal,           // this exists in your table
    'principal' => $principal,        // use existing column
    'interest' => $interest,          // use existing column
    'total_due' => $totalDue,         // use existing column
    'term_days' => $termDays,
    'due_date' => now()->addDays($termDays),
    'status' => 'pending',
    'disbursed_at' => null,
    'balance_remaining' => $totalDue,
    'transaction_id' => null,
]);

            DB::commit();

            // Dispatch disbursement job
            DisburseLoanJob::dispatch($loan);

            return redirect()->route('dashboard')
                ->with('success', '💰 Loan request queued. Disbursement will be processed shortly!');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Loan creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Something went wrong. Try again.');
        }
    }

    /**
     * Pay the active loan
     */
    public function pay(Request $request)
    {
        $loan = Auth::user()->loans()
            ->whereIn('status', ['active', 'pending'])
            ->latest()
            ->first();

        if (!$loan) {
            return redirect()->route('dashboard')
                ->with('error', 'No active loan to pay.');
        }

        $loan->update([
            'status' => 'paid',
            'balance_remaining' => 0,
        ]);

        return redirect()->route('dashboard')
            ->with('success', '✅ Loan successfully paid!');
    }
}