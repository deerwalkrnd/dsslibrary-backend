<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowBookController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

RateLimiter::for('api', function ($request) {
    return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
});

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users/logout', [AuthController::class, 'userlogout']);
});

Route::middleware(['auth:sanctum', 'restrictRole:admin'])->group(function () {
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::get('/users', [AuthController::class, 'show']);
    Route::get('/students', [AuthController::class, 'showStudents']);

    Route::put('/students/{id}', [AuthController::class, 'editStudent'])->name('students.update');
    Route::delete('/students/{id}', [AuthController::class, 'deleteStudent'])->name('students.destroy');

    Route::resource('books', BookController::class)->names('books')->except('index');

    Route::post('/borrow/checkout', [BorrowBookController::class, 'checkout'])->name('checkout');
    Route::post('/borrow/checkin/{id}', [BorrowBookController::class, 'checkin'])->name('checkin');
    Route::get('/borrow-records', [BorrowBookController::class, 'allBooks'])->name('allBooks');
});

Route::get('/books', [BookController::class, 'index'])->name('books.get');
Route::middleware(['auth:sanctum'])->get('/borrow-records/my-user', [BorrowBookController::class, 'myBooks'])->name('myBooks');
