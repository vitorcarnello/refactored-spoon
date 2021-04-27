<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

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

Route::name('api.')->group(function () {

    Route::post('/register', RegisterController::class)->name('register');

    //auth routes
    Route::name('auth.')->prefix('auth')->group(function () {
        Route::post('/login', LoginController::class)->name('login');
    });

    //authenticated routes
    Route::middleware('auth:sanctum')->group(function() {

    });
});