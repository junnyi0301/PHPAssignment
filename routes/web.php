<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/admin', function () {
    return view('admin.product.index');
})->middleware('auth')->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/product', [ProductController::class, 'index'])->name('admin.product.index');
    Route::post('/admin/product/create', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/admin/product/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::patch('/admin/product/{product}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::delete('/admin/product/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
});

require __DIR__ . '/auth.php';
