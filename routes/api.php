<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/catestore')->group(function () {
    Route::get('cart', [CartController::class, 'index']);
    Route::resource('credit-card', PaymentMethodController::class);
    Route::resource('sales', SaleController::class);
});
