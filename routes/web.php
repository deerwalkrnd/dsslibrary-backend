<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;

Route::get('/api/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/api/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::post('/logout',[GoogleAuthController::class, 'logout'])->name('logout'); 

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::middleware('auth:sanctum')->post('/change-password', [AuthController::class, 'changePassword']);
Route::middleware('auth:sanctum')->post('/users/logout', [AuthController::class, 'userlogout']);


Route::post('/auth/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum','restrictRole:admin','password.changed']], function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::get('/users', [AuthController::class, 'show']);
    
});