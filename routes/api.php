<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/funcionarios', [UserController::class, 'index']);
    Route::post('/funcionarios', [UserController::class, 'store']);
    Route::get('/funcionarios/{id}', [UserController::class, 'show']);
    Route::put('/funcionarios/{id}', [UserController::class, 'update']);
    Route::delete('/funcionarios/{id}', [UserController::class, 'destroy']);
});
