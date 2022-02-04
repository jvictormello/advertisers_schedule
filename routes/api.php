<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/catestore')->group(function () {
    Route::get('cart', CartController::class);
    Route::get('credit-card', [PaymentMethodController::class, 'index']);
    Route::get('credit-card/', [PaymentMethodController::class, 'show']);
    Route::post('credit-card', [PaymentMethodController::class, 'store']);
    Route::put('credit-card/{id}', [PaymentMethodController::class, 'update']);
    Route::delete('credit-card/{id}', [PaymentMethodController::class, 'delete']);
});
