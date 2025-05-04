<?php

use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\WesternFoodController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;
use App\Models\Food;
use App\Payment\PaypalPayment;
use Illuminate\Support\Facades\Auth;
use Faker\Provider\ar_EG\Payment;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('home', ['products' => Food::take(8)->get()]);
});

Route::get('/home', function () {
    return view('home', ['products' => Food::take(8)->get()]);
})->middleware(PreventBackHistory::class)->name('home');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware(['auth', PreventBackHistory::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', PreventBackHistory::class])->group(function () {
    Route::post('/payment', [MenuController::class, 'payment'])->name('payment');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
});

Route::middleware(['auth', PreventBackHistory::class, CheckAdmin::class])->group(function () {
    Route::get('/admin', function () {
        return view('admin.product.index', ['products' => Food::all()]);
    })->name('admin');
    Route::get('/admin/create', function () {
        return view('admin.product.create');
    })->name('admin.create');

    Route::get('/admin/edit/{food}', [FoodController::class, 'edit'])->name('admin.edit');
    Route::patch('/admin/update/{food}', [FoodController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{food}', [FoodController::class, 'destroy'])->name('admin.destroy');
    Route::post('/admin/store', [FoodController::class, 'store'])->name('admin.store');
});

Route::get('/western-food', [WesternFoodController::class, 'index']);

Route::post('/pay', [PaymentController::class, 'pay'])->name("pay");

Route::get('success', [PaypalPayment::class, 'success'])->name('success');
Route::get('error', [PaymentController::class, 'error'])->name('error');

//new added wj
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'edit'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/user-list', [ProfileController::class, 'showUserListAdmin'])->name('admin.users');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

require __DIR__ . '/auth.php';
Route::get('/query-foods', function () {
    $category = request('category');
    $xmlPath = public_path('foods.xml');

    $doc = new DOMDocument();
    $doc->load($xmlPath);

    $xpath = new DOMXPath($doc);
    $query = "/foods/food";

    if ($category) {
        $query .= "[category='$category']";
    }

    $foods = $xpath->query($query);

    foreach ($foods as $food) {
        $name = $food->getElementsByTagName('name')->item(0)->nodeValue;
        $price = $food->getElementsByTagName('price')->item(0)->nodeValue;
        echo "<p><strong>$name</strong> – $$price</p>";
    }
});



require __DIR__ . '/auth.php';
