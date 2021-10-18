<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpaceshipController;

Route::apiResource('spaceship', SpaceshipController::class);
