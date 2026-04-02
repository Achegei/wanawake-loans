<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Loan;
use App\Jobs\DisburseLoanJob;
use App\Models\AgentAccessCode;

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
            'agent_code' => 'required|string', // Agent code required
        ]);

        // Prevent any ongoing loans
        $hasExistingLoan = $user->loans()
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($hasExistingLoan) {
            return redirect()->route('dashboard')
                ->with('error', 'You already have an ongoing loan.');
        }

        // Check if agent code exists and is unused
        $code = AgentAccessCode::where('code', strtoupper($request->agent_code))
                ->where('used', false)
                ->first();

        if (!$code) {
            return back()->withErrors([
                'agent_code' => 'Invalid or already used code'
            ])->withInput();
        }

        // Loan calculations
        $principal = $request->amount;
        $interest = $principal == 100 ? 30 : 50;
        $totalDue = $principal + $interest;

        $disbursedAt = now();
        $dueDate = $disbursedAt->copy()->setHour(22)->setMinute(0)->setSecond(0);
        if ($disbursedAt->greaterThan($dueDate)) {
            $dueDate->addDay();
        }

        DB::beginTransaction();

        try {
            // Create loan record
            $loan = $user->loans()->create([
                'amount' => $principal,
                'principal' => $principal,
                'interest' => $interest,
                'total_due' => $totalDue,
                'term_days' => 1,
                'disbursed_at' => $disbursedAt,
                'due_date' => $dueDate,
                'status' => 'pending',
                'balance_remaining' => $totalDue,
                'transaction_id' => null,
                'agent_id' => $code->sales_agent_id, // link loan to agent
                'access_code_id' => $code->id,
            ]);

            // Mark code as used
            $code->update(['used' => true]);

            DB::commit();

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