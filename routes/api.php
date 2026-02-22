<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

Route::get('/health', [HealthController::class, 'index']);

Route::post('/payments', [PaymentController::class, 'store']);
Route::get('/payments/{id}', [PaymentController::class, 'show']);

Route::get('/users/{id}/balance', [BalanceController::class, 'show']);
