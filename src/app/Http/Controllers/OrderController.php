<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Jersey;
use App\Mail\OrderReceipt;
use Illuminate\Support\Facades\Mail;
use App\Models\Transaction;
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
        $request->validate([
            'phone_number' => 'required|string',
            'item_type' => 'required|in:ticket,jersey',
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            // Calculate Amount
            $amount = 0;
            $itemName = '';

            if ($request->item_type === 'ticket') {
                $ticket = Ticket::findOrFail($request->item_id);
                if ($ticket->quantity_available < $request->quantity) {
                    return response()->json(['message' => 'Not enough stock.'], 400);
                }
                $amount = $ticket->price * $request->quantity;
                $itemName = $ticket->type . ' Ticket';
            } else {
                $jersey = Jersey::findOrFail($request->item_id);
                $amount = $jersey->price * $request->quantity;
                $itemName = 'Jersey';
            }

            // Create Transaction Record (PENDING)
            $externalRef = 'ORD-' . strtoupper(Str::random(8));

            $transaction = Transaction::create([
                'external_reference' => $externalRef,
                'phone_number' => $request->phone_number,
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

            DB::commit();

            // Initiate Push via Service
            $response = $this->lipiaService->initiateStkPush(
                $request->phone_number,
                $amount,
                $externalRef
            );

            // Update with Lipia Reference
            $transaction->update([
                'lipia_reference' => $response['data']['TransactionReference'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'STK Push sent',
                'lipia_reference' => $transaction->lipia_reference
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order Init Error: " . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // 3. Poll Status & Create Order on Success
    // public function checkStatus($reference)
    // {
    //     try {
    //         $transaction = Transaction::where('lipia_reference', $reference)->firstOrFail();

    //         // If local DB says success, return immediately
    //         if ($transaction->status === 'SUCCESS') {
    //             return response()->json(['status' => 'SUCCESS']);
    //         }

    //         // Check API Status
    //         $response = $this->lipiaService->checkStatus($reference);

    //         // Note: Node.js checks: data.response.Status
    //         $apiStatus = strtoupper($response['data']['response']['Status'] ?? 'PENDING');

    //         if ($apiStatus === 'SUCCESS' || $apiStatus === 'COMPLETED') {

    //             // Use transaction to ensure atomic order creation
    //             DB::transaction(function () use ($transaction) {
    //                 // Lock for update to prevent double order creation
    //                 $trx = Transaction::lockForUpdate()->find($transaction->id);

    //                 if ($trx->status !== 'SUCCESS') {
    //                     $trx->update(['status' => 'SUCCESS']);

    //                     $meta = json_decode($trx->metadata, true);

    //                     // Reduce Stock (for Tickets)
    //                     if ($meta['item_type'] === 'ticket') {
    //                         $ticket = Ticket::lockForUpdate()->find($meta['item_id']);
    //                         if ($ticket)
    //                             $ticket->decrement('quantity_available', $meta['quantity']);
    //                     }

    //                     // Create Order and assign it variable to send the order details in the email
    //                     $order =
    //                         Order::create([
    //                             'customer_id' => $meta['user_id'],
    //                             'product' => $meta['item_name'],
    //                             'quantity' => $meta['quantity'],
    //                             'price' => $trx->amount,
    //                             'status' => 'Paid',
    //                             'transaction_ref' => $trx->external_reference
    //                         ]);
    //                     // Send receipt email
    //                     $user = \App\Models\User::find($meta['user_id']);
    //                     Mail::to($user->email)->send(new OrderReceipt($order, $user));
    //                 }
    //             });

    //             return response()->json(['status' => 'SUCCESS']);
    //         }

    //         if ($apiStatus === 'FAILED' || $apiStatus === 'CANCELLED') {
    //             $transaction->update(['status' => 'FAILED']);
    //             return response()->json(['status' => 'FAILED']);
    //         }

    //         return response()->json(['status' => 'PENDING']);

    //     } catch (\Exception $e) {
    //         Log::error("Status Check Error: " . $e->getMessage());
    //         return response()->json(['status' => 'PENDING']);
    //     }
    // }
     public function checkStatus($reference)
{
    try {
        $transaction = Transaction::where('lipia_reference', $reference)->firstOrFail();

        if ($transaction->status === 'SUCCESS') {
            return response()->json(['status' => 'SUCCESS']);
        }

        $response = $this->lipiaService->checkStatus($reference);
        $apiStatus = strtoupper($response['data']['response']['Status'] ?? 'PENDING');

        if ($apiStatus === 'SUCCESS' || $apiStatus === 'COMPLETED') {

            $order = null;
            $user = null;

            DB::transaction(function () use ($transaction, &$order, &$user) {
                $trx = Transaction::lockForUpdate()->find($transaction->id);

                if ($trx->status !== 'SUCCESS') {
                    $trx->update(['status' => 'SUCCESS']);
                    $meta = json_decode($trx->metadata, true);

                    if ($meta['item_type'] === 'ticket') {
                        $ticket = Ticket::lockForUpdate()->find($meta['item_id']);
                        if ($ticket) $ticket->decrement('quantity_available', $meta['quantity']);
                    }

                    $order = Order::create([
                        'customer_id' => $meta['user_id'],
                        'product' => $meta['item_name'],
                        'quantity' => $meta['quantity'],
                        'price' => $trx->amount,
                        'status' => 'Paid',
                        'transaction_ref' => $trx->external_reference
                    ]);

                    $user = \App\Models\User::find($meta['user_id']);
                }
            });

            // Send email AFTER transaction completes
            if ($order && $user) {
                try {
                    Mail::to($user->email)->send(new OrderReceipt($order, $user));
                } catch (\Exception $e) {
                    Log::error("Email send failed: " . $e->getMessage());
                }
            }

            return response()->json(['status' => 'SUCCESS']);
        }

        if ($apiStatus === 'FAILED' || $apiStatus === 'CANCELLED') {
            $transaction->update(['status' => 'FAILED']);
            return response()->json(['status' => 'FAILED']);
        }

        return response()->json(['status' => 'PENDING']);

    } catch (\Exception $e) {
        Log::error("Status Check Error: " . $e->getMessage());
        return response()->json(['status' => 'PENDING']);
    }
}

    // 4. Admin Sales Stats
    public function salesStats()
    {
        $jerseyRevenue = Order::where('product', 'LIKE', '%Jersey%')
            ->sum(DB::raw('price * quantity'));

        $ticketRevenue = Order::where('product', 'LIKE', '%Ticket%')
            ->sum(DB::raw('price   * quantity'));

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
