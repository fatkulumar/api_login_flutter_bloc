<?php

    use Illuminate\Support\Facades\Route;

    Route::post('/login', App\Http\Controllers\Api\Auth\LoginController::class);
    Route::post('/register', App\Http\Controllers\Api\Auth\RegisterController::class);
    Route::post('/logout', App\Http\Controllers\Api\Auth\LogoutController::class)->middleware(['auth:sanctum']);