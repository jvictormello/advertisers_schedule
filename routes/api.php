<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/catestore')->group(function () {
    Route::get('cart', CartController::class);
});
