<?php

use App\Http\Controllers\Api\CoffeePodsController;
use App\Http\Controllers\Api\LocationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {

    // LOCATION
    Route::get('location/nearest/{postcode}', [LocationsController::class, 'getNearest']);
    Route::post('location/create', [LocationsController::class, 'create']);

    // PODS
    Route::post('pods/cashback/calculate', [CoffeePodsController::class, 'getCashbackAmount']);
});
