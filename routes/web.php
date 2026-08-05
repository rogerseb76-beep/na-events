<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParticipantController;
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

    Route::get('/admin/participants', [ParticipantController::class, 'index'])
        ->name('admin.participants');

    Route::get('/admin/participants/{participant}/edit', [ParticipantController::class, 'edit'])
        ->name('admin.participants.edit');

    Route::put('/admin/participants/{participant}', [ParticipantController::class, 'update'])
        ->name('admin.participants.update');

    Route::delete('/admin/participants/{participant}', [ParticipantController::class, 'destroy'])
        ->name('admin.participants.destroy');

});

require __DIR__.'/auth.php';