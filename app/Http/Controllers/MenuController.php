<?php

namespace App\Http\Controllers;

use App\Decorators\SizeDecorator;
use App\Decorators\FoodDecorator;
use App\Models\Order;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Models\Food;

class MenuController extends Controller
{
    public function payment(Request $request)
    {
        $xml = $request->input('xmlInput');

        return view('payment.payment', ['xml' => $xml]);
    }

    public function index()
    {
        $foods = Food::all();
        $foodList = [];

        foreach ($foods as $food) {
            $decorator = new FoodDecorator($food);
            $sizeDecorated = new SizeDecorator($decorator);
            $foodList[] = $sizeDecorated;
        }

        return view('order.menu', ['products' => $foodList]);
    }

    public function pay(Request $request)
    {
        if ($request->input('consumeMethod' == 'dineIn')) {
            Order::create([
                'user_id' => Auth::user()->id,
                'xml' => $request->input('xmlInput'),
                'address' => $request->input('address'),
                'postal_code' => $request->input('postalCode'),
                'city' => $request->input('city'),
                'payment_method' => $request->input('paymentMethod'),
                'consumeMethod' => $request->input('consumeMethod'),
                'totalPrice' => 100
            ]);
        } else {
        }
    }
}