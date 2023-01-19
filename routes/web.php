<?php

use App\Http\Controllers\HomepageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index']);
Route::post('/', [HomepageController::class, 'store']);
Route::post('/subscribe', [HomepageController::class, 'subscribe'])->name('subscribe');
