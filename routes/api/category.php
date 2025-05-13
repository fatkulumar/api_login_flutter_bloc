<?php

    use App\Http\Controllers\Api\Guest\CategoryController;
    use Illuminate\Support\Facades\Route;

    Route::apiResource('/category', CategoryController::class)->except(['create', 'edit'])->middleware('auth:sanctum');