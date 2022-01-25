<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login', [\App\Http\Controllers\frontend\AuthController::class, 'showLogin'])->name('show.login');

Route::group(['prefix' => ''], function () {
    Route::get('/', [\App\Http\Controllers\frontend\HomeController::class, 'index']);
    Route::get('/home', [\App\Http\Controllers\frontend\HomeController::class, 'index'])->name('home');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [\App\Http\Controllers\backend\DashboardController::class, 'index']);
    Route::get('/dashboard', [\App\Http\Controllers\backend\DashboardController::class, 'dashboard'])->name('dashboard');
});
