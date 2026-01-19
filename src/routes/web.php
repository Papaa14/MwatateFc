<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Mail\MyTestEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Coach\LineupController;

// Authentication Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::get('/reset', function () {
    return view('auth.reset');
})->name('reset');

// --- PROTECTED DASHBOARD ROUTES ---
// We will protect these later, for now, they just return views.

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard'); // Admin

// Route::middleware(['auth', 'role:coach'])->group(function () {
//     Route::get('/coach-dashboard', [App\Http\Controllers\Coach\DashboardController::class, 'index'])->name('coach-dashboard');
//     Route::get('/coach/training/create', [App\Http\Controllers\Coach\TrainingController::class, 'create'])->name('coach.training.create');
//     Route::get('/coach/message/create', [App\Http\Controllers\Coach\MessageController::class, 'create'])->name('coach.message.create');
// }); // Coach

Route::get('/player-dashboard', function () {
    return view('player.dashboard');
})->name('players-dashboard'); // Player (Note: I corrected the name from your example)

Route::get('/fan-dashboard', function () {
    return view('fan.index');
})->name('fan-dashboard'); // Fan (Note: I corrected the name from your example)

Route::get('/coach-dashboard', function () {
    return view('coach.dashboard');
})->name('coach-dashboard'); // Coach

Route::get('/send-test-email', function () {
    // Replace with the recipient's email
    Mail::to('calvinmangi627@gmail.com')->send(new MyTestEmail());

    return "Email Sent Successfully!";
});
