<?php

namespace App\Mail;

use App\User;
use App\Orders;
use Stripe\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $orders; 
    public $customer; 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orders, $customer)
    {
        $this->orders = $orders;
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.receiptMail');
    }
}
