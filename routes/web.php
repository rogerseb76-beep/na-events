<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventSessionController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    [HomeController::class, 'index']
)->name('home');

Route::get(
    '/evenements/{event:slug}',
    [HomeController::class, 'show']
)->name('public.events.show');

Route::get(
    '/reservation/{eventSession}',
    [ReservationController::class, 'create']
)->name('reservations.create');

Route::post(
    '/reservation/{eventSession}',
    [ReservationController::class, 'store']
)->name('reservations.store');

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get(
            '/',
            [DashboardController::class, 'index']
        )->name('dashboard');

        Route::get(
            '/settings',
            [SettingsController::class, 'edit']
        )->name('settings.edit');

        Route::put(
            '/settings',
            [SettingsController::class, 'update']
        )->name('settings.update');

        Route::get(
            '/participants',
            [ParticipantController::class, 'index']
        )->name('participants');

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

        Route::patch(
            '/participants/{participant}/present',
            [AttendanceController::class, 'present']
        )->name('participants.present');

        Route::patch(
            '/participants/{participant}/absent',
            [AttendanceController::class, 'absent']
        )->name('participants.absent');

        Route::patch(
            '/participants/{participant}/pending',
            [AttendanceController::class, 'pending']
        )->name('participants.pending');

        Route::get(
            '/exports',
            [ExportController::class, 'index']
        )->name('exports.index');

        Route::get(
            '/exports/participants',
            [ExportController::class, 'participants']
        )->name('exports.participants');

        Route::get(
            '/exports/events/{event}',
            [ExportController::class, 'eventWorkbook']
        )->name('exports.events.workbook');

        Route::get(
            '/pdf/events/{event}/attendance',
            [PdfController::class, 'eventAttendance']
        )->name('pdf.events.attendance');

        Route::get(
            '/pdf/events/{event}/sessions/{session}/attendance',
            [PdfController::class, 'sessionAttendance']
        )->name('pdf.sessions.attendance');

        Route::get(
            '/events/{event}/duplicate',
            [EventController::class, 'duplicateForm']
        )->name('events.duplicate.form');

        Route::post(
            '/events/{event}/duplicate',
            [EventController::class, 'duplicateStore']
        )->name('events.duplicate.store');

        Route::resource(
            'events',
            EventController::class
        )->except('show');

        Route::get(
            '/events/{event}/sessions',
            [EventSessionController::class, 'index']
        )->name('events.sessions.index');

        Route::get(
            '/events/{event}/sessions/create',
            [EventSessionController::class, 'create']
        )->name('events.sessions.create');

        Route::post(
            '/events/{event}/sessions',
            [EventSessionController::class, 'store']
        )->name('events.sessions.store');

        Route::get(
            '/events/{event}/sessions/{session}/edit',
            [EventSessionController::class, 'edit']
        )->name('events.sessions.edit');

        Route::put(
            '/events/{event}/sessions/{session}',
            [EventSessionController::class, 'update']
        )->name('events.sessions.update');

        Route::delete(
            '/events/{event}/sessions/{session}',
            [EventSessionController::class, 'destroy']
        )->name('events.sessions.destroy');
    });

require __DIR__ . '/auth.php';
