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
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


// ->middleware(['manager'])->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


//public view routes
Route::get('/book-now', [TypeController::class, 'book'])->name('types.book');
Route::get('/room-details', [RatingController::class, 'index'])->name('ratings.index');
Route::get('/rent-motorcycle', [RentMotorcycle::class, 'rent'])->name('rents.rent');
Route::get('/rent-details/{id}', [RentMotorcycle::class, 'show'])->name('rents.show');
Route::get('/room-details/{id}', [TypeController::class, 'show'])->name('types.show');


Route::middleware('manager')->group(function () {
Route::get('/dashboard', function () {return view('dashboard');});
    Route::get('/admin_view/room', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/admin_view/room/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/admin_view/room', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/admin_view/room/{id}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::patch('/admin_view/room/{id}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/admin_view/room/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    Route::get('/admin_view/rents', [RentMotorcycle::class, 'index'])->name('rents.index');
    Route::get('/admin_view/rents/create', [RentMotorcycle::class, 'create'])->name('rents.create');
    Route::post('/admin_view/rents', [RentMotorcycle::class, 'store'])->name('rents.store');
    Route::get('/admin_view/rents/{id}/edit', [RentMotorcycle::class, 'edit'])->name('rents.edit');
    Route::patch('/admin_view/rents/{id}', [RentMotorcycle::class, 'update'])->name('rents.update');
    Route::delete('/admin_view/rents/{id}', [RentMotorcycle::class, 'destroy'])->name('rents.destroy');

    Route::get('/admin_view/type', [TypeController::class, 'index'])->name('types.index');
    Route::get('/admin_view/type/create', [TypeController::class, 'create'])->name('types.create');
    Route::post('/admin_view/type', [TypeController::class, 'store'])->name('types.store');
    Route::get('/admin_view/type/{id}/edit', [TypeController::class, 'edit'])->name('types.edit');
    Route::patch('/admin_view/type/{id}', [TypeController::class, 'update'])->name('types.update');
    Route::delete('/admin_view/type/{id}', [TypeController::class, 'destroy'])->name('types.destroy');

    Route::get('/admin_view/facility', [FacilityController::class, 'index'])->name('facility.index');
    Route::get('/admin_view/facility/create', [FacilityController::class, 'create'])->name('facility.create');
    Route::post('/admin_view/facility', [FacilityController::class, 'store'])->name('facility.store');
    Route::get('/admin_view/facility/{id}/edit', [FacilityController::class, 'edit'])->name('facility.edit');
    Route::patch('/admin_view/facility/{id}', [FacilityController::class, 'update'])->name('facility.update');
    Route::delete('/admin_view/facility/{id}', [FacilityController::class, 'destroy'])->name('facility.destroy');
    
    Route::get('/admin_view/users', [ProfileController::class, 'usersIndex'])->name('users.index');
    Route::get('/admin/users/{id}/edit', [ProfileController::class, 'usersEdit'])->name('users.edit');
    Route::patch('/admin/users/{id}', [ProfileController::class, 'usersUpdate'])->name('users.update');
});

Route::middleware('role:manager,receptionist')->group(function () {
    Route::get('/admin_view/reservations', [ReservationController::class, 'showAll'])->name('reservations.index');
});

Route::middleware('auth')->group(function () {
    Route::post('/ratings/{id}/reviews', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/search-rooms', [AvailableRoomController::class, 'search'])->name('rooms.search');
    Route::get('/search-rentals', [RentMotorcycle::class, 'search'])->name('rents.search');
    Route::post('/rent-details/{id}/review', [RentMotorcycle::class, 'storeReview'])->name('rents.review.store');
    Route::get('/room-reservation', [ReservationController::class, 'createRoom'])->name('reservations.createRoom');
    Route::post('/room-reservation', [ReservationController::class, 'storeRoom'])->name('reservations.storeRoom');
    Route::get('/rental-reservation', [ReservationController::class, 'createRental'])->name('reservations.createRental');
    Route::post('/rental-reservation', [ReservationController::class, 'storeRental'])->name('reservations.storeRental');
    Route::get('/payment', [PaymentController::class, 'payment'])->name('payment.show');
});

require __DIR__ . '/auth.php';
