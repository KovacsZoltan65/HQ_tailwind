<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // ----------------------------------------
    // DASHBOARD
    // ----------------------------------------
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // ----------------------------------------
    // BOOKS
    // ----------------------------------------
    Route::post('/upload-books', [BookController::class, 'upload'])->name('upload-books');
    Route::post('/upload-books-revert', [BookController::class, 'uploadRevert']);
    
    Route::resource('/books', BookController::class)->names([
        'index' => 'books'
    ]);
});
