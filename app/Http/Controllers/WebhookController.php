<?php

namespace App\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends Controller
{
    /**
     * Handle charge succeeded.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleChargeSucceeded($payload)
    {
        // Send email
    }
    
    /**
     * Handle charge failed.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleChargeFailed($payload)
    {
        // Send email and update table with cancel.
    }

    /**
     * Handle subs cancel.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleSubscriptionScheduleCanceled($payload)
    {
        // Send email.
    }
}
