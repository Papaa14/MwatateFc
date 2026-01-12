<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\LipiaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $lipiaService;

    public function __construct(LipiaService $lipiaService)
    {
        $this->lipiaService = $lipiaService;
    }

    /**
     * 1. Initiate Payment (STK Push)
     */
    public function pay(Request $request)
    {
        // 1. Validate
        $request->validate([
            'phone_number' => 'required|numeric|digits:12',
            'amount' => 'required|numeric|min:1'
        ]);

        // 2. Create Local Transaction Record
        $externalRef = 'ORD-' . Str::upper(Str::random(10));

        $transaction = Transaction::create([
            'external_reference' => $externalRef,
            'phone_number' => $request->phone_number,
            'amount' => $request->amount,
            'status' => 'PENDING',
            'metadata' => json_encode(['customer' => 'Client API'])
        ]);

        try {
            // 3. Call Service
            $response = $this->lipiaService->initiateStkPush(
                $request->phone_number,
                $request->amount,
                $externalRef
            );

            // 4. Update with Lipia Reference
            $transaction->update([
                'lipia_reference' => $response['data']['TransactionReference'] ?? null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'STK Push sent to phone!',
                'data' => [
                    'lipia_reference' => $transaction->lipia_reference,
                    'order_id' => $externalRef
                ]
            ], 200);

        } catch (\Exception $e) {
            $transaction->update(['status' => 'FAILED']);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 2. Check Status Manually (Polling)
     */
    public function verifyStatus($lipiaReference)
    {
        $transaction = Transaction::where('lipia_reference', $lipiaReference)->firstOrFail();

        try {
            $response = $this->lipiaService->checkStatus($lipiaReference);
            $paymentData = $response['data']['response']; // Based on your snippet structure

            // Map Lipia status to our DB status
            $status = ($paymentData['Status'] === 'Success') ? 'SUCCESS' : 'FAILED';

            $transaction->update([
                'status' => $status,
                'receipt_number' => $paymentData['MpesaReceiptNumber'] ?? null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction status updated',
                'data' => [
                    'current_status' => $status,
                    'receipt' => $transaction->receipt_number
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 3. Handle Callback (Webhook)
     */
    public function handleCallback(Request $request)
    {
        Log::info('Lipia Callback:', $request->all());

        $data = $request->input('data'); // Adjust based on actual Lipia callback structure

        if ($data) {
            // Find transaction by reference
            $ref = $data['TransactionReference'] ?? null;
            $transaction = Transaction::where('lipia_reference', $ref)->first();

            if ($transaction) {
                // Update status logic
                $status = ($data['Status'] ?? '') === 'Success' ? 'SUCCESS' : 'FAILED';

                $transaction->update([
                    'status' => $status,
                    'receipt_number' => $data['MpesaReceiptNumber'] ?? null
                ]);
            }
        }

        return response()->json(['message' => 'Callback received']);
    }
}
