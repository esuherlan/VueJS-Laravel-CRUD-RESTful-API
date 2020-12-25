<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PassportAuthController;
use App\Http\Controllers\API\CustomerController;

Route::post('register', [PassportAuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::post('/customers/store', [CustomerController::class, 'store']);
    Route::get('/customers/{id?}', [CustomerController::class, 'show']);
    Route::post('/customers/update/{id?}', [CustomerController::class, 'update']);
    Route::delete('/customers/{id?}', [CustomerController::class, 'destroy']);
});