<?php

use App\Http\Controllers\Api\Address\AddressController;
use App\Http\Controllers\Api\Address\ProvinceController;
use App\Http\Controllers\Api\Auth\AuthenticationSessionController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Ping Route
 */

Route::get('/ping', fn() => response()->json(['message' => 'pong']))
    ->middleware('auth:sanctum')
    ->name('ping');

/**
 * Authentication Routes
 */
Route::post('/login', [AuthenticationSessionController::class, 'store'])
    ->name('login');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register');

Route::delete('/logout', [AuthenticationSessionController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('logout');

/**
 * Profile Routes
 */
Route::middleware('auth:sanctum')->prefix('/profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
});

Route::middleware('auth:sanctum')->prefix('/password')->name('password.')->group(function () {
    Route::patch('/', [PasswordController::class, 'update'])->name('update');
});

/**
 * User Management Routes
 */
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('/users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::patch('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth:sanctum'])->prefix('/addresses')->name('addresses.')->group(function () {
    Route::get('/provinces', [ProvinceController::class, 'index'])->name('provinces.index');

    Route::get('/', [AddressController::class, 'index'])->name('index');
    Route::get('/{address}', [AddressController::class, 'show'])->name('show');
    Route::post('/', [AddressController::class, 'store'])->name('store');
    Route::patch('/{address}', [AddressController::class, 'update'])->name('update');
    Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
});
