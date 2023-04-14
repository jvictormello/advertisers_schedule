<?php

use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

# AuthenticationController
Route::post('login/advertiser', [AuthenticationController::class, 'loginAdvertiser']);
Route::post('login/contractor', [AuthenticationController::class, 'loginContractor']);

# AdvertiserController
Route::get('advertisers/test', [AdvertiserController::class, 'test'])->middleware('auth.advertisers');
Route::resource('advertisers', AdvertiserController::class)->only(['index', 'show']);

# NotificationController
Route::resource('notifications', NotificationController::class)->only(['index'])->middleware('auth.advertisers');

# ScheduleController
Route::put('/schedules/{id}/update-status', [ScheduleController::class, 'updateStatus'])->middleware('auth.advertisers');
Route::resource('schedules', ScheduleController::class)->only(['index'])->middleware('auth.advertisers');
Route::resource('schedules', ScheduleController::class)->only(['destroy', 'store'])->middleware('auth.contractors');
