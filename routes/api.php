<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('api', function ($request) {
    return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
});

Route::get('/auth/google/redirect', [AuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'callback'])->name('auth.google.callback');
Route::post('/logout', [AuthController::class, 'googleLogout'])->name('logout');

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/users/logout', [AuthController::class, 'userlogout']);
});

Route::middleware(['auth:sanctum', 'restrictRole:admin', 'password.changed'])->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::get('/users', [AuthController::class, 'show']);
});
