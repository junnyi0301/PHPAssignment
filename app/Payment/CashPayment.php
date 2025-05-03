<?php

namespace App\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CashPayment implements PaymentStrategyInterface
{
    public function processPayment($amount)
    {
        $order = session('order');
        $address = session('address');
        $postalCode = session('postalCode');
        $city = session('city');
        $consumeMethod = session('consumeMethod');
        $total = session('total');
        $tax = session('tax');
        $subtotal = session('subtotal');

        Order::create([
            'user_id' => Auth::user()->id,
            'order' => $order,
            'address' => $address,
            'postal_code' => $postalCode,
            'city' => $city,
            'payment_method' => "Cash",
            'consumeMethod' => $consumeMethod,
            'totalPrice' => $total,
            'taxPrice' => $tax,
            'subtotalPrice' => $subtotal,
            'status' => 'pending'
        ]);

        return redirect(route('paymentSuccess'));
    }
}
