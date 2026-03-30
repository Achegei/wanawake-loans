<?php

namespace App\Jobs;

use App\Models\Loan; // ✅ Correct import
use App\Services\LoanDisbursementService; // ✅ Import the service
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DisburseLoanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Loan $loan; // ✅ Type-hint the Loan model

    /**
     * Create a new job instance.
     *
     * @param Loan $loan
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = new LoanDisbursementService();

        $success = $service->disburseToMobile($this->loan);

        if ($success) {
            $this->loan->update([
                'status' => 'active',
                'disbursed_at' => now(),
            ]);
        } else {
            \Log::error('Disbursement failed', ['loan_id' => $this->loan->id]);
        }
    }
}