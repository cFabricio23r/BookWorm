<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\SummarizeController;
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
    Route::controller(SummarizeController::class)
        ->prefix('summarize')
        ->name('summarize.')
        ->group(function () {
            Route::post('/', 'summarize')->name('summarize');
        });
});
