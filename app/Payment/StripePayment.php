<?php

namespace App\Payment;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePayment implements PaymentStrategyInterface
{
    public function processPayment($amount)
    {
        // Set your secret key
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Create a PaymentIntent (no actual payment captured)
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100, // Stripe uses cents
                'currency' => 'myr',
                'payment_method_types' => ['card'],
            ]);

            return "Successfully connected to Stripe. PaymentIntent ID: " . $paymentIntent->id;
        } catch (\Exception $e) {
            return "Failed to connect to Stripe: " . $e->getMessage();
        }
    }
}
