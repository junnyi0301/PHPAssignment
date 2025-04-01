<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home', ['products' => Food::take(8)->get()]);
});

Route::get('/home', function () {
    return view('home', ['products' => Food::take(8)->get()]);
})->middleware('prevent-back-history')->name('home');

Route::get('/admin', function () {
    return view('admin.product.index');
})->middleware('auth', 'prevent-back-history', 'admin')->name('admin');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/menu', function () {
    return view('components.menu', [
        'products' => Food::all()
    ]);
})->middleware('auth', 'prevent-back-history')->name('menu');

require __DIR__ . '/auth.php';