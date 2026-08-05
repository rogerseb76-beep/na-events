<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get(
    '/reservation/{eventSession}',
    [ReservationController::class, 'create']
)->name('reservations.create');

Route::post(
    '/reservation/{eventSession}',
    [ReservationController::class, 'store']
)->name('reservations.store');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/participants', [ParticipantController::class, 'index'])
        ->name('participants');

    Route::get(
        '/participants/{participant}/edit',
        [ParticipantController::class, 'edit']
    )->name('participants.edit');

    Route::put(
        '/participants/{participant}',
        [ParticipantController::class, 'update']
    )->name('participants.update');

    Route::delete(
        '/participants/{participant}',
        [ParticipantController::class, 'destroy']
    )->name('participants.destroy');

    Route::resource('events', EventController::class)
        ->except('show');
});

require __DIR__.'/auth.php';