<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/coach-dashboard', function () {
    return view('coach.dashboard');
})->name('coach-dashboard'); // Coach

Route::get('/player-dashboard', function () {
    return view('player.dashboard');
})->name('players-dashboard'); // Player (Note: I corrected the name from your example)

Route::get('/fan-dashboard', function () {
    return view('fan.index');
})->name('fan-dashboard'); // Fan (Note: I corrected the name from your example)