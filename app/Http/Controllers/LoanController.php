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
     * Show the loan application form
     */
    public function create()
    {
        $allowedAmounts = [100, 200]; // Only two options allowed
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
            'agent_code' => 'required|string',
        ]);

        // Check for existing pending or active loan
        if ($user->loans()->whereIn('status', ['pending', 'active'])->exists()) {
            return redirect()->route('dashboard')
                ->with('error', 'You already have an ongoing loan.');
        }

        $inputCode = strtoupper(trim($request->agent_code));

        $code = AgentAccessCode::whereRaw('UPPER(TRIM(code)) = ?', [$inputCode])
                               ->where('used', false)
                               ->first();

        if (!$code) {
            return back()->withErrors(['agent_code' => 'Invalid or already used code'])->withInput();
        }

        // Calculate loan details
        $principal = $request->amount;
        $interest = $principal == 100 ? 30 : 50;
        $totalDue = $principal + $interest;

        $disbursedAt = now();
        // Set due date as end of the disbursement day (11:59 PM)
        $dueDate = $disbursedAt->copy()->setTimezone(config('app.timezone'))->setHour(23)->setMinute(59)->setSecond(0);
        $hoursLeft = now()->diffInHours($dueDate, false); // negative if overdue

        DB::beginTransaction();

        try {
            // Create the loan
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
                'agent_id' => $code->sales_agent_id,
                'access_code_id' => $code->id,
            ]);

            // 🔥 Immediately mark agent code as used to prevent reuse
            $code->update([
                'used' => true,
                'used_at' => now(),
            ]);

            DB::commit();

            // Queue automatic disbursement via job
            DisburseLoanJob::dispatch($loan);

            return redirect()->route('dashboard')
                ->with('success', '💰 Loan request queued. Disbursement will be processed shortly!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Loan creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
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

        // Mark loan as paid
        $loan->update([
            'status' => 'paid',
            'balance_remaining' => 0,
        ]);

        return redirect()->route('dashboard')
            ->with('success', '✅ Loan successfully paid!');
    }
}