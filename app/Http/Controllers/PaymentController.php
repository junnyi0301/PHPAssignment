<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Payment\CashPayment;
use App\Payment\PaypalPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Omnipay\Omnipay;

class PaymentController extends Controller
{


    public function pay(Request $request)
    {
        session([
            'order' => $request->input('order'),
            'address' => $request->input('address'),
            'postalCode' => $request->input('postalCode'),
            'city' => $request->input('city'),
            'consumeMethod' => $request->input('consumeMethod'),
            'total' => $request->input('total'),
            'tax' => $request->input('tax'),
            'subtotal' => $request->input('subtotal')
        ]);

        if ($request->has('cash')) {
            $paymentMethod = new CashPayment();
        } else {
            $paymentMethod = new PaypalPayment();
        }

        $paymentMethod->processPayment($request->input('total'));
    }
}
