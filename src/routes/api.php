<?php

use App\Http\Controllers\Api\Admin\FixtureController;
use App\Http\Controllers\Api\Admin\NewsController;
use App\Http\Controllers\Api\Admin\RegisterController;
use App\Http\Controllers\Api\Admin\TicketController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require a valid token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

});


Route::post('/admin/register', [RegisterController::class, 'Register']);
Route::put('/admin/update/{id}', [RegisterController::class, 'updateUser']);
Route::delete('/admin/delete/{id}', [RegisterController::class, 'deleteUser']);
Route::apiResource('news', NewsController::class);
Route::apiResource('fixtures', FixtureController::class);
Route::apiResource('tickets', TicketController::class);

Route::get('/user-counts', [RegisterController::class, 'getUserCounts']);
Route::post('/register', [RegisterController::class, 'Register']);
Route::delete('/users/{id}', [RegisterController::class, 'deleteUser']);
Route::get('/users', [RegisterController::class, 'getUsers']);
