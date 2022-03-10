<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/catestore')->group(function () {
    Route::get('cart', [CartController::class, 'listAllProducts']);

    Route::resource('credit-card', PaymentMethodController::class);

    Route::get('sales/{userId}', [SaleController::class, 'listCostomerSales']);
    Route::resource('sales', SaleController::class)->except(['show']);
});
