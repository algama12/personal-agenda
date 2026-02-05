<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('calendar.month', ['date' => Carbon::today()->format('Y-m-d')]);
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'restrict.users'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('calendar.month', ['date' => Carbon::today()->format('Y-m-d')]);
    })->name('dashboard');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/day/{date}', [CalendarController::class, 'day'])->name('calendar.day');
    Route::get('/calendar/week/{date}', [CalendarController::class, 'week'])->name('calendar.week');
    Route::get('/calendar/month/{date}', [CalendarController::class, 'month'])->name('calendar.month');
    Route::get('/calendar/year/{year}', [CalendarController::class, 'year'])->name('calendar.year');

    Route::apiResource('events', EventController::class);
    Route::apiResource('notes', NoteController::class);
    Route::patch('/notes/{note}/toggle-pin', [NoteController::class, 'togglePin'])->name('notes.toggle-pin');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
