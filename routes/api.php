<?php

    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;

    Route::get('/user', UserController::class)->middleware(['auth:sanctum']);
    require base_path('routes/api/auth.php');
    require base_path('routes/api/category.php');