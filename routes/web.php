<?php

use App\Http\Controllers\AvailableRoomController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RentMotorcycle;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//public view routes
Route::get('/book-now', [TypeController::class, 'index'])->name('types.index');
Route::get('/room-details', [RatingController::class, 'index'])->name('ratings.index');
Route::get('/rent-motorcycle', [RentMotorcycle::class, 'index'])->name('rents.index');
Route::get('/room-details/{id}', [TypeController::class, 'show'])->name('types.show');


Route::middleware('manager')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/create_room', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/create_room', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/create_rental', [RentMotorcycle::class, 'create'])->name('rents.create');
    Route::post('/create_rental', [RentMotorcycle::class, 'store'])->name('rents.store');
    Route::get('/create_type', [TypeController::class, 'create'])->name('types.create');
    Route::post('/create_type', [TypeController::class, 'store'])->name('types.store');
    Route::get('/create_facility', [FacilityController::class, 'create'])->name('facility.create');
    Route::post('/create_facility', [FacilityController::class, 'store'])->name('facility.store');
    Route::resource('rooms', RoomController::class);
    Route::post('/ratings/{id}/reviews', [RatingController::class, 'store'])->name('ratings.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/search-rooms', [AvailableRoomController::class, 'search'])->name('rooms.search');
    Route::get('/search-rentals', [RentMotorcycle::class, 'search'])->name('rents.search');
    Route::get('/room-reservation', [ReservationController::class, 'createRoom'])->name('reservations.createRoom');
    Route::post('/room-reservation', [ReservationController::class, 'storeRoom'])->name('reservations.storeRoom');
    Route::get('/rental-reservation', [ReservationController::class, 'createRental'])->name('reservations.createRental');
    Route::post('/rental-reservation', [ReservationController::class, 'storeRental'])->name('reservations.storeRental');
    Route::get('/payment', [PaymentController::class, 'payment'])->name('payment.show');

});

require __DIR__ . '/auth.php';
