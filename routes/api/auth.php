<?php

    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;

    Route::get('/user', UserController::class)->middleware(['auth:sanctum']);
    Route::post('/login', App\Http\Controllers\Api\Auth\LoginController::class);
    Route::post('/register', App\Http\Controllers\Api\Auth\RegisterController::class);
    Route::post('/logout', App\Http\Controllers\Api\Auth\LogoutController::class)->middleware(['auth:sanctum']);