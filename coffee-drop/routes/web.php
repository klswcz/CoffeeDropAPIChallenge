<?php

use App\Http\Controllers\Api\LocationsController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->prefix('api')->group(function () {

    // LOCATION
    Route::get('location/nearest/{postcode}', [LocationsController::class, 'getNearest']);
    Route::post('location/create', [LocationsController::class, 'create']);

    // PODS
    Route::post('pods/cashback/calculate', 'CoffeePodsController@getCashbackAmount');
});
