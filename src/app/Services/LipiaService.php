<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class LipiaService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('LIPIA_API_KEY');
        $this->baseUrl = env('LIPIA_BASE_URL');
    }

    /**
     * Initiate STK Push
     */
    public function initiateStkPush($phone, $amount, $reference, $metadata = [])
    {
        $endpoint = '/payments/stk-push';

        $payload = [
            'phone_number' => $phone,
            'amount' => $amount,
            'external_reference' => $reference,
            'callback_url' => env('LIPIA_CALLBACK_URL'),
            'metadata' => $metadata
        ];

        return $this->sendRequest($endpoint, 'POST', $payload);
    }

    /**
     * Check Transaction Status
     */
    public function checkStatus($lipiaReference)
    {
        $endpoint = '/payments/status?reference=' . urlencode($lipiaReference);
        return $this->sendRequest($endpoint, 'GET');
    }

    /**
     * Raw cURL Helper
     */
    private function sendRequest($endpoint, $method, $data = null)
    {
        $url = $this->baseUrl . $endpoint;
        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Fast timeout

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error("Lipia cURL Error: " . $error);
            throw new Exception("Connection failed: " . $error);
        }

        $result = json_decode($response, true);

        if ($httpCode !== 200) {
            Log::error("Lipia HTTP Error $httpCode", [$result]);
            throw new Exception($result['message'] ?? 'Unknown Error from Payment Gateway');
        }

        if (isset($result['success']) && !$result['success']) {
            throw new Exception($result['message'] ?? 'Operation failed');
        }

        return $result;
    }
}
