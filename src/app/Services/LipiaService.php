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

    public function initiateStkPush($phone, $amount, $reference, $metadata = [])
    {
        $endpoint = '/payments/stk-push';

        $payload = [
            'phone_number' => $phone,
            'amount' => $amount,
            'external_reference' => $reference,
            'callback_url' => env('LIPIA_CALLBACK_URL'), // Must be public (e.g., ngrok)
           'metadata' => (object)($metadata ?: [])
        ];

        // LOG REQUEST FOR DEBUGGING
        Log::info("Lipia Request Payload:", $payload);

        return $this->sendRequest($endpoint, 'POST', $payload);
    }

    public function checkStatus($lipiaReference)
    {
        $endpoint = '/payments/status?reference=' . urlencode($lipiaReference);
        return $this->sendRequest($endpoint, 'GET');
    }

    private function sendRequest($endpoint, $method, $data = null)
    {
        if (!$this->apiKey || !$this->baseUrl) {
            throw new Exception("Lipia API Configuration missing in .env file.");
        }

        $url = $this->baseUrl . $endpoint;
        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        // FIX FOR LOCALHOST 500 ERRORS (SSL)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // LOG RAW RESPONSE
        Log::info("Lipia API Response [$httpCode]: " . $response);

        if ($error) {
            Log::error("Lipia cURL Error: " . $error);
            throw new Exception("Connection to Payment Gateway failed: " . $error);
        }

        $result = json_decode($response, true);

        // Handle Non-200 responses
        if ($httpCode >= 400) {
            $msg = $result['message'] ?? 'Unknown Error from Gateway';
            throw new Exception("Gateway Error ($httpCode): $msg");
        }

        if (isset($result['success']) && !$result['success']) {
            throw new Exception($result['message'] ?? 'Operation failed');
        }

        return $result;
    }
}
