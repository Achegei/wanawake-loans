<?php

namespace App\Services;

use IntaSend\IntaSendPHP\Transfer;
use App\Models\Loan;
use Illuminate\Support\Facades\Log;

class LoanDisbursementService
{
    protected Transfer $client;

    public function __construct()
    {
        $credentials = [
            'secret_key' => config('services.intasend.intasend_secret_key'),
            'publishable_key' => config('services.intasend.publishable_key'),
        ];

        $this->client = new Transfer();
        $this->client->init($credentials);
    }

    /**
     * Disburse loan via M-Pesa
     * Returns: ['success' => bool, 'tracking_id' => ?string, 'error' => ?string]
     */
    public function disburseToMobile(Loan $loan): array
    {
        try {
            $phone = $this->formatPhone($loan->user->phone);

            $transactions = [[
                'account' => $phone,
                'amount' => (string) $loan->principal,
            ]];

            $response = $this->client->mpesa("KES", $transactions);

            Log::info('IntaSend response', [
                'loan_id' => $loan->id,
                'response' => $response
            ]);

            // Auto-approve if needed
            if (!empty($response->requires_approval) && $response->requires_approval === "YES") {
                $response = $this->client->approve($response);
            }

            // SUCCESS CASE
            if (!empty($response->tracking_id)) {
                return [
                    'success' => true,
                    'tracking_id' => $response->tracking_id,
                    'error' => null
                ];
            }

            return [
                'success' => false,
                'tracking_id' => null,
                'error' => 'No tracking ID returned'
            ];

        } catch (\Throwable $e) {
            Log::error('Disbursement failed', [
                'loan_id' => $loan->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'tracking_id' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    private function formatPhone(string $phone): string
    {
        // Ensure 2547XXXXXXXX format
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            return '254' . substr($phone, 1);
        }

        if (str_starts_with($phone, '7')) {
            return '254' . $phone;
        }

        return $phone;
    }
}