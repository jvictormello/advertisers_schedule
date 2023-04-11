<?php

use App\Http\Controllers\AdvertiserController;
use Illuminate\Support\Facades\Route;

Route::resource('advertisers', AdvertiserController::class)->only([
    'index', 'show'
]);
