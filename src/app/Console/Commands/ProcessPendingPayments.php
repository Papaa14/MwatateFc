<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Fixture;
use App\Services\SafaricomService;
use App\Mail\OrderReceipt;
use App\Mail\TicketBookingConfirmation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ProcessPendingPayments extends Command
{
    protected $signature = 'payments:process-pending {--checkout-id=}';
    protected $description = 'Process pending M-Pesa payments and create orders';

    public function handle()
    {
        $checkoutId = $this->option('checkout-id');
        
        if ($checkoutId) {
            $transactions = Transaction::where('lipia_reference', $checkoutId)
                ->where('status', 'PENDING')
                ->get();
        } else {
            $transactions = Transaction::where('status', 'PENDING')
                ->whereNotNull('lipia_reference')
                ->where('created_at', '>', now()->subHours(24))
                ->get();
        }

        if ($transactions->isEmpty()) {
            $this->info('No pending transactions found.');
            return 0;
        }

        $safaricomService = app(SafaricomService::class);
        $processed = 0;

        foreach ($transactions as $transaction) {
            $this->info("Checking transaction: {$transaction->lipia_reference}");
            
            $response = $safaricomService->queryStk($transaction->lipia_reference);
            
            if (!$response) {
                $this->warn("Failed to query: {$transaction->lipia_reference}");
                continue;
            }

            $resultCode = $response['ResultCode'] ?? null;
            
            if ($resultCode === '0' || $resultCode === 0) {
                $this->info("✅ Payment successful!");
                
                try {
                    DB::transaction(function () use ($transaction, $response) {
                        $receiptNumber = null;
                        if (isset($response['CallbackMetadata']['Item'])) {
                            foreach ($response['CallbackMetadata']['Item'] as $item) {
                                if ($item['Name'] === 'MpesaReceiptNumber') {
                                    $receiptNumber = $item['Value'];
                                    break;
                                }
                            }
                        }
                        
                        $transaction->update([
                            'status' => 'SUCCESS',
                            'receipt_number' => $receiptNumber
                        ]);

                        $meta = json_decode($transaction->metadata, true);

                        if ($meta['item_type'] === 'ticket') {
                            $ticket = Ticket::lockForUpdate()->find($meta['item_id']);
                            if ($ticket) {
                                $ticket->decrement('quantity_available', $meta['quantity']);
                                $ticket->fixture()->lockForUpdate()->first()->increment('tickets_sold', $meta['quantity']);
                            }
                        }

                        $order = Order::create([
                            'customer_id' => $meta['user_id'],
                            'product' => $meta['item_name'],
                            'quantity' => $meta['quantity'],
                            'price' => $transaction->amount,
                            'status' => 'Paid',
                            'transaction_ref' => $transaction->external_reference,
                            'section_name' => $meta['section_name'] ?? null,
                            'seat_numbers' => $meta['seat_numbers'] ?? null,
                            'fixture_id' => $meta['fixture_id'] ?? null,
                            'ticket_type' => $meta['ticket_type'] ?? null,
                        ]);

                        $user = \App\Models\User::find($meta['user_id']);

                        if ($user) {
                            try {
                                if ($meta['item_type'] === 'ticket' && $meta['fixture_id']) {
                                    $fixture = Fixture::find($meta['fixture_id']);
                                    if ($fixture && $order->seat_numbers) {
                                        Mail::to($user->email)->send(new TicketBookingConfirmation($order, $user, $fixture));
                                    } else {
                                        Mail::to($user->email)->send(new OrderReceipt($order, $user));
                                    }
                                } else {
                                    Mail::to($user->email)->send(new OrderReceipt($order, $user));
                                }
                                $this->info("📧 Email sent to {$user->email}");
                            } catch (\Exception $emailError) {
                                $this->warn("⚠️ Email failed: " . $emailError->getMessage());
                                Log::error("Email send failed: " . $emailError->getMessage());
                            }
                        }
                    });
                    
                    $processed++;
                    $this->info("Order created successfully!");
                    
                } catch (\Exception $e) {
                    $this->error("Failed to create order: " . $e->getMessage());
                    Log::error("Manual process error: " . $e->getMessage());
                }
            } elseif ($resultCode === '4999' || $resultCode === 4999) {
                $this->warn("⏳ Still processing...");
            } else {
                $this->error("❌ Payment failed with code: {$resultCode}");
                $transaction->update(['status' => 'FAILED']);
            }
        }

        $this->info("\nProcessed {$processed} successful payments.");
        return 0;
    }
}
