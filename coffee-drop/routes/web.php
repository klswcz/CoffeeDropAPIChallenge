<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Api')->prefix('api')->group(function () {

    // LOCATION
    Route::get('location/nearest', 'LocationsController@get');
    Route::post('location/create', 'LocationsController@create');

    // PODS
    Route::post('pods/cashback/calculate', 'CoffeePodsController@getCashbackAmount');
});
