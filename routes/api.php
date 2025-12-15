<?php

use App\Http\Controllers\CallbackController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans-callback', [CallbackController::class, 'midtransCallback']);