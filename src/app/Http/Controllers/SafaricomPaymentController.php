<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\SafaricomService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SafaricomPaymentController extends Controller
{
    protected $safaricomService;

    public function __construct(SafaricomService $safaricomService)
    {
        $this->safaricomService = $safaricomService;
    }

    public function pay(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
            'amount' => 'required|numeric|min:1'
        ]);

        $externalRef = 'ORD-' . Str::upper(Str::random(10));

        $transaction = Transaction::create([
            'external_reference' => $externalRef,
            'phone_number' => $request->phone_number,
            'amount' => $request->amount,
            'status' => 'PENDING',
            'metadata' => json_encode(['customer' => 'Safaricom API'])
        ]);

        try {
            $response = $this->safaricomService->initiatePush(
                $request->amount,
                $request->phone_number,
                $externalRef
            );

            if (!$response || ($response['ResponseCode'] ?? '') !== '0') {
                throw new \Exception($response['ResponseDescription'] ?? 'STK Push failed');
            }

            $transaction->update([
                'lipia_reference' => $response['CheckoutRequestID'] ?? null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'STK Push sent to phone!',
                'data' => [
                    'checkout_request_id' => $transaction->lipia_reference,
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

    public function verifyStatus($checkoutRequestId)
    {
        $transaction = Transaction::where('lipia_reference', $checkoutRequestId)->firstOrFail();

        try {
            $response = $this->safaricomService->queryStk($checkoutRequestId);

            if (!$response) {
                throw new \Exception('Failed to query transaction status');
            }

            $resultCode = $response['ResultCode'] ?? null;
            $status = $resultCode === '0' ? 'SUCCESS' : 'FAILED';

            $transaction->update([
                'status' => $status,
                'receipt_number' => $response['MpesaReceiptNumber'] ?? null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction status updated',
                'data' => [
                    'current_status' => $status,
                    'receipt' => $transaction->receipt_number,
                    'result_desc' => $response['ResultDesc'] ?? null
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function handleCallback(Request $request)
    {
        Log::info('Safaricom Callback:', $request->all());

        $data = $request->input('Body.stkCallback');

        if ($data) {
            $checkoutRequestId = $data['CheckoutRequestID'] ?? null;
            $transaction = Transaction::where('lipia_reference', $checkoutRequestId)->first();

            if ($transaction) {
                $resultCode = $data['ResultCode'] ?? null;
                $status = $resultCode === 0 ? 'SUCCESS' : 'FAILED';

                $receiptNumber = null;
                if (isset($data['CallbackMetadata']['Item'])) {
                    foreach ($data['CallbackMetadata']['Item'] as $item) {
                        if ($item['Name'] === 'MpesaReceiptNumber') {
                            $receiptNumber = $item['Value'];
                            break;
                        }
                    }
                }

                $transaction->update([
                    'status' => $status,
                    'receipt_number' => $receiptNumber
                ]);
            }
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }
}
