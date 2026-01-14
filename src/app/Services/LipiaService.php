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
        $this->baseUrl = rtrim(env('LIPIA_BASE_URL'), '/');
    }

    public function initiateStkPush($phone, $amount, $reference)
    {
        $endpoint = '/payments/stk-push';

        // Clean phone number like Node (just ensure no +)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        // Payload matching Node.js exactly
        $payload = [
            'phone_number' => $cleanPhone,
            'amount' => (int) $amount,
            'external_reference' => $reference,
            'callback_url' => env('LIPIA_CALLBACK_URL')
        ];

        return $this->sendRequest($endpoint, 'POST', $payload);
    }

    public function checkStatus($lipiaReference)
    {
        $endpoint = '/payments/status?reference=' . urlencode($lipiaReference);
        return $this->sendRequest($endpoint, 'GET');
    }

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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local dev

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($httpCode === 200 && ($result['success'] ?? false)) {
            return $result;
        } else {
            // Log exactly what failed
            Log::error("Lipia Error [$httpCode]: " . $response);
            throw new Exception($result['message'] ?? 'Payment Gateway Error');
        }
    }
}
