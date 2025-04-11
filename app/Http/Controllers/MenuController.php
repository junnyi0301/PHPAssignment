<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Decorator\FoodProduct;
use App\Decorator\SizeDecorator;

class MenuController extends Controller
{
    public function payment(Request $request)
    {
        $xml = $request->input('xml');
        $xmlObject = simplexml_load_string($xml);

        foreach ($xmlObject->item as $item) {
            $product = new FoodProduct($item->name, $item->price);
            $decoratedProduct = new SizeDecorator($product, $item->option);
        }


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
}