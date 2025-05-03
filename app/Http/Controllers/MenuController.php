<?php

namespace App\Http\Controllers;

use App\Decorators\SizeDecorator;
use App\Decorators\FoodDecorator;
use App\Models\Order;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Http;

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
            if ($food['category'] == 'Food') {
                $decorated = new SizeDecorator($decorator);
            }
            $foodList[] = $decorated;
        }

        $westernFoods = [];

        try {
            $response = Http::get('http://127.0.0.1:8001/api/western-food');
            if ($response->successful()) {
                $westernFoods = $response->json();
            }
        } catch (\Exception $e) {
            //Error msg
        }

        return view('order.menu', ['products' => $foodList, 'westernFoods' => $westernFoods]);
    }
}
