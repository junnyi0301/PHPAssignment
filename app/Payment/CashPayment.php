<?php

namespace App\Payment;

use Illuminate\Support\Facades\Http;

class CashPayment implements PaymentStrategyInterface
{
    public function processPayment($amount)
    {

        // This is just a mock API call for demonstration
        $response = Http::withHeaders([
            'Authorization' => 'Bearer YOUR_PAYPAL_API_TOKEN',
        ])->post('https://api.paypal.com/v1/payments/payment', [
            'amount' => $amount,
            'currency' => 'USD',
            // Other PayPal payment details
        ]);

        if ($response->successful()) {
            return 'Payment successful via PayPal';
        } else {
            return 'Payment failed via PayPal';
        }
    }
}
