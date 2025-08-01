<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\UploadController;
use App\Http\Controllers\Api\Admin\RegisterController;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require a valid token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // This is a sample protected route to get user info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

//AdminRegister controller to add new member -> coach and player 
Route::post('/admin/register', [RegisterController::class, 'Register']);
Route::put('/admin/update/{id}', [RegisterController::class, 'updateUser']);
Route::delete('/admin/delete/{id}', [RegisterController::class, 'deleteUser']);


//count logic
Route::get('/admin/user-counts', [RegisterController::class, 'getUserCounts']);


//add new routes for the uploadcontroller
Route::post('/admin/fixtures', [UploadController::class, 'addFixture']);
Route::post('/admin/videos', [UploadController::class, 'addVideo']);
Route::post('/admin/news', [UploadController::class, 'addNews']);
