<?php

use Illuminate\Support\Facades\Route;

Route::get('/advertisers', 'App\Http\Controllers\AdvertisersController@list')->middleware('jwt.auth');
Route::get('/advertisers/view/{id?}', 'App\Http\Controllers\AdvertisersController@view')->middleware('jwt.auth');
Route::get('/advertisers/listAvailabilities/{id?}', 'App\Http\Controllers\AdvertisersController@listAvailabilities')->middleware('jwt.auth');
Route::get('/advertisers/viewAvailabilities/{id?}', 'App\Http\Controllers\AdvertisersController@viewAvailabilities')->middleware('jwt.auth');