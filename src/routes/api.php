<?php

use App\Http\Controllers\Api\Admin\FixtureController;
use App\Http\Controllers\Api\Admin\NewsController;
use App\Http\Controllers\Api\Admin\RegisterController;
use App\Http\Controllers\Api\Admin\TicketController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\JerseyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\TrainingSessionController;
use App\Http\Controllers\Api\Admin\VideoAnalysisController;
use App\Http\Controllers\Api\Admin\TeamMessageController;
use App\Http\Controllers\Api\Player\PlayerDashboardController;
use App\Http\Controllers\Api\ChatController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require a valid token)
// Protected routes (require a valid token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    });
});




Route::post('/admin/register', [RegisterController::class, 'Register']);
Route::put('/admin/update/{id}', [RegisterController::class, 'updateUser']);
Route::delete('/admin/delete/{id}', [RegisterController::class, 'deleteUser']);
Route::apiResource('news', NewsController::class);
Route::apiResource('fixtures', FixtureController::class);
Route::apiResource('tickets', TicketController::class);
Route::apiResource('jerseys', JerseyController::class);
Route::apiResource('orders', OrderController::class);
Route::get('/sales-stats', [OrderController::class, 'salesStats']);
Route::apiResource('training-sessions', TrainingSessionController::class);
Route::apiResource('videos', VideoAnalysisController::class);
Route::apiResource('messages', TeamMessageController::class);


Route::get('/user-counts', [RegisterController::class, 'getUserCounts']);
Route::post('/register', [RegisterController::class, 'Register']);
Route::delete('/users/{id}', [RegisterController::class, 'deleteUser']);
Route::put('/users/{id}', [RegisterController::class, 'updateUser']);
Route::get('/users', [RegisterController::class, 'getUsers']);

// Player Dashboard Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/player/dashboard-stats', [PlayerDashboardController::class, 'stats']);
    Route::get('/trainings', [PlayerDashboardController::class, 'trainings']);
    Route::get('/chat/messages', [ChatController::class, 'index']);
    Route::post('/chat/send', [ChatController::class, 'store']);
});


Route::post('/payments/pay', [PaymentController::class, 'pay']);
Route::get('/payments/status/{reference}', [PaymentController::class, 'verifyStatus']);
Route::post('/payments/callback', [PaymentController::class, 'handleCallback']);
