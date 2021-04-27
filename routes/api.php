<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Public\PlanController as PublicPlanController;
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

    //public routes
    Route::name('public.')->prefix('public')->group(function () {
        Route::get('/plan', PublicPlanController::class)->name('plans');
    });

    //admin routes
    Route::name('admin.')->prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::apiResource('/plan', AdminPlanController::class);
    });

    //customer routes
    Route::name('customer.')->prefix('customer')->middleware(['auth:sanctum', 'customer'])->group(function () {
        Route::apiResource('/subscribe', AdminPlanController::class);
    });
});