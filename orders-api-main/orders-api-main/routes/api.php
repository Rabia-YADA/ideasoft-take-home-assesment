<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    Route::apiResource('customers', \App\Http\Controllers\CustomerController::class);
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index']);
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store']);
    Route::get('/orders/{id}', [\App\Http\Controllers\OrderController::class, 'show']);
    Route::delete('/orders/{id}', [\App\Http\Controllers\OrderController::class, 'destroy']);
    Route::get('/orders/{orderId}/discounts', [\App\Http\Controllers\DiscountController::class, 'calculateDiscounts']);
    Route::get('products', [\App\Http\Controllers\ProductController::class, 'index']);

