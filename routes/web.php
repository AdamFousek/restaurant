<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/menu', \App\Http\Controllers\MenuController::class)->name('menu');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('reservations')->group(function () {
        Route::get('/', [\App\Http\Controllers\ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/create', [\App\Http\Controllers\ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/store', [\App\Http\Controllers\ReservationController::class, 'store'])->name('reservations.store');
        Route::delete('/{reservation}/destroy', [\App\Http\Controllers\ReservationController::class, 'destroy'])->name('reservations.destroy');
    });
});

require __DIR__.'/auth.php';
