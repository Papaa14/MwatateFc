<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketBookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;
    public $fixture;

    public function __construct(Order $order, $user, $fixture)
    {
        $this->order = $order;
        $this->user = $user;
        $this->fixture = $fixture;
    }

    public function build()
    {
        return $this->subject('Ticket Booking Confirmation - ' . $this->fixture->opponent . ' Match')
            ->view('emails.ticket-booking', [
                'order' => $this->order,
                'user' => $this->user,
                'fixture' => $this->fixture,
            ]);
    }
}
