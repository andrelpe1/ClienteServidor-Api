<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('/users', [AuthController::class, 'register']);
Route::post('/sessions', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/sessions/{id}', [AuthController::class, 'logout']);
    Route::apiResource('produtos', ProdutoController::class);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::patch('/users/{id}', [UserController::class, 'patch']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
