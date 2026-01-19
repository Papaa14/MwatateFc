<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;

    public function __construct(Order $order, $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function build()
    {
        $pdf = Pdf::loadView('emails.receipts', [
            'order' => $this->order,
            'user' => $this->user
        ]);

        return $this->subject('Payment Receipt - Order #' . $this->order->id)
            ->view('emails.receipts')
            ->attachData($pdf->output(), 'receipt-' . $this->order->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
