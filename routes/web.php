<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\CatalogController::class, 'index'])->name('catalog.index');
Route::get('/prestamo/{book}', [\App\Http\Controllers\CatalogController::class, 'requestForm'])->name('catalog.request');
Route::post('/prestamo/{book}', [\App\Http\Controllers\CatalogController::class, 'storeRequest'])->name('catalog.store');

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Segmento de Administración
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    
    Route::get('/loans', [\App\Http\Controllers\LoanController::class, 'index'])->name('loans.index');
    Route::patch('/loans/{loan}/return', [\App\Http\Controllers\LoanController::class, 'returnBook'])->name('loans.return');
    
    Route::resource('books', \App\Http\Controllers\BookController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('avisos', \App\Http\Controllers\AvisoController::class);
});
