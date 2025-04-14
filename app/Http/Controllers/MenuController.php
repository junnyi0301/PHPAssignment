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
        $xml = $request->input('xml');
        $xmlObject = simplexml_load_string($xml);


        foreach ($xmlObject->item as $item) {
            Order::create([
                'food_id' => $xml['id'],
                'option' => $xml['option'],
                'quantity' => $xml['quantity'],
                'user_id' => Auth::user()->id,
            ]);
        }

        $paymentAmount = [
            'subtotal' => $request->input('subtotal'),
            'tax' => $request->input('tax'),
            'total' => $request->input('total'),
        ];

        return view('payment.payment', [$paymentAmount]);
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
}