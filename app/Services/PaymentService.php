<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service class for handling payment operations.
 * Centralizes payment-related logic, especially QRIS payment generation.
 */
class PaymentService
{
    protected string $baseUrl = 'https://atlantich2h.com';

    /**
     * Create a new deposit.
     *
     * @param int $amount
     * @param string $type (e.g., 'ewallet', 'bank', 'va')
     * @param string $method (e.g., 'qris', 'bca')
     * @return array
     * @throws \Exception
     */
    public function createDeposit(int $amount, string $type, string $method): array
    {
        $apiKey = env('ATLANTICH2H_API_KEY');
        
        if (empty($apiKey)) {
             throw new \Exception('AtlanticH2H API Key is not configured.');
        }

        // reff_id must be unique, using timestamp and random string
        $reffId = 'DEP-' . time() . '-' . Str::random(5);

        if ($amount < 500) {
            throw new \Exception('Minimum deposit amount is Rp 500.');
        }

        $payload = [
            'api_key' => $apiKey,
            'reff_id' => $reffId,
            'nominal' => $amount,
            'type' => $type,
            'metode' => $method,
        ];

        try {
            $response = Http::asForm()->post("{$this->baseUrl}/deposit/create", $payload);

            $result = $response->json();

            if (!$result['status']) {
                 Log::error('AtlanticH2H Create Deposit Failed', [
                    'payload' => [
                        'nominal' => $amount,
                        'type' => $type,
                        'method' => $method,
                    ],
                    'response' => $result
                ]);
                throw new \Exception('Failed to create deposit: ' . ($result['message'] ?? 'Unknown error'));
            }

            $data = $result['data'];

            // Map keys to match View expectations
            if (isset($data['qr_image'])) {
                $data['qrImageUrl'] = $data['qr_image'];
            }
            if (isset($data['expired_at'])) {
                $data['expirationTime'] = $data['expired_at'];
            }

            return $data;

        } catch (\Exception $e) {
            Log::error('AtlanticH2H API Error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Check deposit status.
     *
     * @param string $id AtlanticH2H Deposit ID
     * @return array
     * @throws \Exception
     */
    public function checkStatus(string $id): array
    {
         $apiKey = env('ATLANTICH2H_API_KEY');

        try {
            $response = Http::asForm()->post("{$this->baseUrl}/deposit/status", [
                'api_key' => $apiKey,
                'id' => $id,
            ]);

            $result = $response->json();

             if (!$result['status']) {
                throw new \Exception('Failed to check status: ' . ($result['message'] ?? 'Unknown error'));
            }

            return $result['data'];
        } catch (\Exception $e) {
            Log::error('AtlanticH2H Check Status Error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

     /**
     * Cancel a deposit.
     *
     * @param string $id AtlanticH2H Deposit ID
     * @return array
     * @throws \Exception
     */
    public function cancelDeposit(string $id): array
    {
        $apiKey = env('ATLANTICH2H_API_KEY');

        try {
             $response = Http::asForm()->post("{$this->baseUrl}/deposit/cancel", [
                'api_key' => $apiKey,
                'id' => $id,
            ]);

            $result = $response->json();

            if (!$result['status']) {
                 throw new \Exception('Failed to cancel deposit: ' . ($result['message'] ?? 'Unknown error'));
            }

            return $result['data'];
        } catch (\Exception $e) {
             Log::error('AtlanticH2H Cancel Error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get available payment methods.
     *
     * @param string|null $type (optional) 'bank', 'ewallet', 'va'
     * @param string|null $method (optional)
     * @return array
     */
    public function getMethods(?string $type = null, ?string $method = null): array
    {
         $apiKey = env('ATLANTICH2H_API_KEY');
         
         $params = ['api_key' => $apiKey];
         if ($type) $params['type'] = $type;
         if ($method) $params['metode'] = $method;

        try {
             $response = Http::asForm()->post("{$this->baseUrl}/deposit/metode", $params);
             $result = $response->json();

             if (!($result['status'] ?? false)) {
                 return [];
             }

             return $result['data'];
        } catch (\Exception $e) {
             Log::error('AtlanticH2H Get Methods Error', ['error' => $e->getMessage()]);
             return [];
        }
    }
    
    /**
     * Format amount to IDR currency string.
     *
     * @param  int|float  $amount
     */
    public function formatCurrency($amount): string
    {
        return 'Rp '.number_format($amount, 0, ',', '.');
    }
}
