<?php

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

Route::prefix('/inventory/{type}/{id}/')->group(function () {
    Route::get('count',[\App\Http\Controllers\InventoryController::class, 'count']);
    Route::post('amount',[\App\Http\Controllers\InventoryController::class, 'setAmount']);
    Route::post('amount/increment',[\App\Http\Controllers\InventoryController::class, 'increment']);
});


