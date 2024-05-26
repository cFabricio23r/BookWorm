<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\SummaryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware(['throttle:auth'])->group(function () {
    Route::controller(AuthController::class)
        ->prefix('auth')
        ->name('auth.')
        ->group(function () {
            Route::post('/login', 'login')->name('login');
            Route::post('/register', 'register')->name('register');
            Route::post('/logout', 'logout')->name('logout');
        });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(SummaryController::class)
        ->prefix('summary')
        ->name('summary.')
        ->group(function () {
            Route::post('/', 'store')->name('store');
            Route::get('/', 'index')->name('index');
            Route::get('/{summary}', 'show')->name('show');
            Route::post('/{summary}/chat', 'chat')->name('chat');
        });
});
