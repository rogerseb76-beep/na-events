<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/reservation/{eventSession}', [ReservationController::class, 'create'])
    ->name('reservations.create');

Route::post('/reservation/{eventSession}', [ReservationController::class, 'store'])
    ->name('reservations.store');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});

require __DIR__.'/auth.php';