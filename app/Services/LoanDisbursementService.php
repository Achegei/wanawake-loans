<?php

namespace App\Services;

use IntaSend\IntaSendPHP\Transfer;
use App\Models\Loan;

class LoanDisbursementService
{
    protected Transfer $client;

    public function __construct()
    {
        // Initialize the IntaSend Transfer client with API credentials
        $credentials = [
            'token' => env('INTASEND_API_TOKEN'),          // Your secret token
            'publishable_key' => env('INTASEND_PUBLISHABLE_KEY'), // Your public key
        ];

        $this->client = new Transfer();
        $this->client->init($credentials);
    }

    /**
     * Disburse loan to user's mobile number via IntaSend M-Pesa B2C
     */
    public function disburseToMobile(Loan $loan): bool
    {
        $amount = $loan->principal;
        $phone = preg_replace('/^0/', '254', $loan->user->phone);

        // Prepare transaction array
        $transactions = [
            [
                'account' => $phone,
                'amount' => (string) $amount,
            ]
        ];

        try {
    $response = $this->client->mpesa("KES", $transactions);

    \Log::info('IntaSend raw response', [
        'loan_id' => $loan->id,
        'response' => $response
    ]);

    if (isset($response->requires_approval) && $response->requires_approval === "YES") {
        $response = $this->client->approve($response);
    }

    if (!empty($response->tracking_id)) {
        return true;
    }

} catch (\Throwable $e) {
    \Log::error('Loan Disbursement Error: ' . $e->getMessage(), [
        'loan_id' => $loan->id,
        'user_id' => $loan->user_id,
    ]);

        }

        return false;
    }
}