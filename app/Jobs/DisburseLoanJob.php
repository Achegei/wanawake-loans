<?php

namespace App\Jobs;

use App\Models\Loan;
use App\Models\AgentAccessCode;
use App\Services\LoanDisbursementService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DisburseLoanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;        // retry 3 times
    public $backoff = 60;     // wait 60 seconds

    public Loan $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function handle(): void
{
    Log::info("Starting DisburseLoanJob for Loan ID: {$this->loan->id}");

    $loan = Loan::find($this->loan->id);
    if (!$loan || $loan->status !== 'pending') return;

    DB::beginTransaction();

    try {
        $service = new LoanDisbursementService();
        $result = $service->disburseToMobile($loan);

        if (!$result['success']) {
            DB::rollBack();
            Log::error("Loan disbursement failed for Loan ID: {$loan->id}", ['error' => $result['error']]);
            return;
        }

        $loan->update([
            'status' => 'active',
            'disbursed_at' => now(),
            'transaction_id' => 'TXN-' . strtoupper(\Str::random(8)),
            'disbursement_tracking_id' => $result['tracking_id'],
            // optionally generate repayment_invoice_id here
            'repayment_invoice_id' => 'INV-' . strtoupper(\Str::random(8)),
        ]);

        if ($loan->access_code_id) {
            $code = AgentAccessCode::find($loan->access_code_id);
            if ($code && !$code->used) {
                $code->update(['used' => true, 'used_at' => now()]);
            }
        }

        DB::commit();
        Log::info("DisburseLoanJob completed for Loan ID: {$loan->id}");

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Disbursement error for Loan ID: {$loan->id}", ['error' => $e->getMessage()]);
    }
}
}