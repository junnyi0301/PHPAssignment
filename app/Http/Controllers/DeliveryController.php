<?php
// app/Http/Controllers/DeliveryController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DeliveryController extends Controller
{
    public function showForm()
    {
        return view('delivery.form');
    }

    public function calculate(Request $request)
{
    $validated = $request->validate([
        'area' => 'required|string|max:255',
        'street_number' => 'required|string|max:50',
        'house_number' => 'required|string|max:50',
        'notes' => 'nullable|string|max:500'
    ]);

    // Fixed 60 minutes delivery time
    $currentTime = now();
    $estimatedTime = now()->addHour(); // Exactly 1 hour later

    // Get cart data (replace with your actual cart implementation)
    $cartItems = session('cart', []);
    $totalPrice = collect($cartItems)->sum(function($item) {
        return $item['price'] * $item['quantity'];
    });

    return view('delivery.confirmation', [
        'deliveryData' => $validated,
        'estimatedTime' => $estimatedTime,
        'currentTime' => $currentTime,
        'cartItems' => $cartItems,
        'totalPrice' => $totalPrice
    ]);
}
}