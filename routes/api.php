<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/clients')->name('clients.')->group(function () {
    Route::get('/', [ClientController::class, 'list'])->name('list');

    Route::prefix('/{client}')->name('show.')->group(function () {
        Route::get('/', [ClientController::class, 'show'])->name('info');
        Route::patch('/', [ClientController::class, 'update'])->name('update');
        Route::delete('/', [ClientController::class, 'delete'])->name('delete');
    });
});

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::get('/me', [AuthController::class, 'me'])->name('me');

    Route::middleware('guest')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
