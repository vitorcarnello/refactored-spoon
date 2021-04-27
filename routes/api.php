<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Customer\PlanController as CustomerPlanController;
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

Route::name('api.')->group(function () {
    //auth routes
    Route::name('auth.')->prefix('auth')->group(function () {
        Route::post('/register', RegisterController::class)->name('register');
        Route::post('/login', LoginController::class)->name('login');
    });

    //admin routes
    Route::name('api.admin.')->prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::apiResource('plans', AdminPlanController::class);
    });

    //customer routes
    Route::name('api.customer.')->prefix('customer')->middleware(['auth:sanctum', 'customer'])->group(function () {
        Route::get('/plans', CustomerPlanController::class)->name('plans');
    });
});