<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/room', [RoomController::class, 'index'])->name('rooms');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/book-now', [TypeController::class, 'index'])->name('types.index');

Route::get('/search-rooms', [ReservationController::class, 'search'])->name('rooms.search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/create_room', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/create_room', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/create_type', [TypeController::class, 'create'])->name('types.create');
    Route::post('/create_type', [TypeController::class, 'store'])->name('types.store');

    

    Route::resource('rooms', RoomController::class);
});

require __DIR__ . '/auth.php';
