<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Jersey; // Ensure you have this model
use App\Models\Transaction; // Ensure you have this model
use App\Services\LipiaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $lipiaService;

    public function __construct(LipiaService $lipiaService)
    {
        $this->lipiaService = $lipiaService;
    }

    // 1. Get User Orders
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())->latest()->get();
        return response()->json(['data' => $orders]);
    }

    // 2. Initiate STK Push Payment
    public function initiatePayment(Request $request)
    {
        // 1. Validation
        $request->validate([
           'phone_number' => ['required', 'string', 'regex:/^(254\d{9}|0[17]\d{8})$/'],
            'item_type' => 'required|in:ticket,jersey',
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $payerPhone = '254' . substr(preg_replace('/[^0-9]/', '', $request->phone_number), -9);
        try {
            DB::beginTransaction();

            // 2. Logic to determine price
            $amount = 0;
            $itemName = '';

            if ($request->item_type === 'ticket') {
                $ticket = Ticket::findOrFail($request->item_id);
                if ($ticket->quantity_available < $request->quantity) {
                    return response()->json(['message' => 'Sold out or insufficient quantity.'], 400);
                }
                $amount = $ticket->price * $request->quantity;
                $itemName = $ticket->type . ' Ticket';
            } else {
                $jersey = Jersey::findOrFail($request->item_id);
                $amount = $jersey->price * $request->quantity;
                $itemName = 'Jersey';
            }

            // 3. Create Transaction Record (Status: PENDING)
            $externalRef = 'ORD-' . strtoupper(Str::random(8));

            $transaction = Transaction::create([
                'external_reference' => $externalRef,
                'phone_number' => $payerPhone,
                'amount' => $amount,
                'status' => 'PENDING',
                'metadata' => json_encode([
                    'user_id' => Auth::id(),
                    'item_type' => $request->item_type,
                    'item_id' => $request->item_id,
                    'quantity' => $request->quantity,
                    'item_name' => $itemName
                ])
            ]);

            DB::commit(); // Commit here so we have the ID before calling API

            // 4. Call API Service

            $response = $this->lipiaService->initiateStkPush(
                $payerPhone,
                $amount,
                $externalRef,

            );


            // 5. Update with Provider Reference
            $transaction->update([
                'lipia_reference' => $response['data']['TransactionReference'] ?? 'REF-' . time()
            ]);

            return response()->json([
                'status' => 'pending',
                'message' => 'STK Push sent.',
                'lipia_reference' => $transaction->lipia_reference
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Payment Init Error: " . $e->getMessage());
            Log::error($e->getTraceAsString());

            // Return 500 but with JSON so frontend can read it
            return response()->json([
                'message' => 'Payment failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus($reference)
    {
        try {
            $transaction = Transaction::where('lipia_reference', $reference)->firstOrFail();

            if ($transaction->status === 'SUCCESS') {
                return response()->json(['status' => 'SUCCESS']);
            }

            $response = $this->lipiaService->checkStatus($reference);

            // Adjust this key based on your actual Lipia API response structure
            $lipiaStatus = $response['data']['response']['Status'] ?? 'Pending';

            if ($lipiaStatus === 'Success' || $lipiaStatus === 'Completed') {
                if ($transaction->status !== 'SUCCESS') {
                    DB::transaction(function () use ($transaction) {
                        $transaction->update(['status' => 'SUCCESS']);
                        $meta = json_decode($transaction->metadata, true);

                        // Reduce Stock
                        if ($meta['item_type'] === 'ticket') {
                            $ticket = Ticket::lockForUpdate()->find($meta['item_id']);
                            if ($ticket)
                                $ticket->decrement('quantity_available', $meta['quantity']);
                        }

                        // Create Order
                        Order::create([
                            'customer_id' => $meta['user_id'],
                            'product' => $meta['item_name'],
                            'quantity' => $meta['quantity'],
                            'price' => $transaction->amount,
                            'status' => 'Paid',
                            'transaction_ref' => $transaction->external_reference
                        ]);
                    });
                }
                return response()->json(['status' => 'SUCCESS']);
            } elseif ($lipiaStatus === 'Failed') {
                $transaction->update(['status' => 'FAILED']);
                return response()->json(['status' => 'FAILED']);
            }

            return response()->json(['status' => 'PENDING']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'PENDING']);
        }
    }
    // 4. Sales Stats (For Admin Dashboard)
    public function salesStats()
    {
        $jerseyRevenue = Order::where('product', 'LIKE', '%Jersey%')
            ->sum('price * quantity'); // Assuming price stored is total, otherwise price * quantity

        $ticketRevenue = Order::where('product', 'LIKE', '%Ticket%')
            ->sum('price * quantity');

        $totalRevenue = $jerseyRevenue + $ticketRevenue;
        $recentOrders = Order::latest()->take(5)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'jersey_revenue' => $jerseyRevenue,
                'ticket_revenue' => $ticketRevenue,
                'total_revenue' => $totalRevenue,
                'recent_orders' => $recentOrders
            ]
        ]);
    }
}
