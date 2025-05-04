<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WesternFoodController extends Controller
{
    public function index()
    {
        $response = Http::get('http://127.0.0.1:8001/api/western-food');
        $westernFoods = $response->json();

        return view('western-food', compact('westernFoods'));
    }
}
