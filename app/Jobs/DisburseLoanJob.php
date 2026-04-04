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
            $success = $service->disburseToMobile($loan);

            if (!$success) {
                DB::rollBack();
                Log::error("Disbursement failed for Loan ID: {$loan->id}");
                return;
            }

            $loan->update([
                'status' => 'active',
                'disbursed_at' => now(),
                'transaction_id' => 'TXN-' . strtoupper(\Str::random(8)),
            ]);

            DB::commit();

            // Mark agent code used
            if ($loan->access_code_id) {
                $code = AgentAccessCode::find($loan->access_code_id);
                if ($code && !$code->used) {
                    $code->update(['used' => true, 'used_at' => now()]);
                }
            }

            Log::info("DisburseLoanJob completed for Loan ID: {$loan->id}");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Disbursement error for Loan ID: {$loan->id}", ['error' => $e->getMessage()]);
        }
    }
}