<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home', ['products' => Food::take(8)->get()]);
});

Route::get('/home', function () {
    return view('home', ['products' => Food::take(8)->get()]);
})->middleware('prevent-back-history')->name('home');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware('auth', 'prevent-back-history')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'prevent-back-history')->group(function () {
    Route::post('/payment', [MenuController::class, 'payment'])->name('payment');
    Route::post('/pay', [MenuController::class, 'pay'])->name('pay');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
});

Route::middleware('auth', 'prevent-back-history')->group(function () {
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




require __DIR__ . '/auth.php';