<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| BonImplant Public Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'setlocale'])->group(function () {
    // Language switcher
    Route::get('/language/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

    // Home page
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

    // News
    Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');

    // Contact form submission
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});
