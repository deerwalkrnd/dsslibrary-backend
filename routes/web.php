<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BulkUploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});
Route::get('/auth/google/redirect', [AuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'callback'])->name('auth.google.callback');
Route::post('/logout', [AuthController::class, 'googleLogout'])->name('logout');

Route::get('/import-form', function () {
    return view('users-import');
});
Route::get('/import-form/books', function () {
    return view('books-import');
});
Route::get('/import-form/borrows', function () {
    return view('borrows-import');
});
