<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

    Route::post('/login', App\Http\Controllers\Api\Auth\LoginController::class)->middleware('guest');;
    Route::post('/register', App\Http\Controllers\Api\Auth\RegisterController::class)->middleware('guest');;
    Route::post('/logout', App\Http\Controllers\Api\Auth\LogoutController::class)->middleware(['auth:sanctum']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->middleware('guest');