<?php

namespace App\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Omnipay\Omnipay;

class PaypalPayment implements PaymentStrategyInterface
{
    private $gateway;
    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_SECRET_ID'));
        $this->gateway->setTestMode(true);
    }
    public function processPayment($amount)
    {
        try {
            $response = $this->gateway->purchase(array(
                'amount' => $amount,
                'currency' => 'MYR',
                'returnUrl' => route('success'),
                'cancelUrl' => route('home'),
            ))->send();

            if ($response->isRedirect()) {
                // Redirect to PayPal
                $response->redirect();
            } else {
                // Payment failed
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));
            $response = $transaction->send();
            if ($response->isSuccessful()) {
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
                    'payment_method' => "Paypal",
                    'consumeMethod' => $consumeMethod,
                    'totalPrice' => $total,
                    'taxPrice' => $tax,
                    'subtotalPrice' => $subtotal,
                    'status' => 'success'
                ]);
            }

            return redirect(route('paymentSuccess'));
        }
    }

    public function error(Request $request)
    {
        return "Payment Unsuccessful";
    }
}