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
Route::group(['middleware' => ['guest']], function () {
    Route::get('login', [\App\Http\Controllers\frontend\AuthController::class, 'showLogin'])->name('show.login');
    Route::post('login', [\App\Http\Controllers\frontend\AuthController::class, 'login'])->name('login');
    Route::post('admin-login', [\App\Http\Controllers\backend\LogController::class, 'login'])->name('admin.login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('scontent/{path}', [\App\Http\Controllers\ScontentController::class, 'show'])->name('scontent.show');
    Route::group(['prefix' => ''], function () {
        Route::get('logout', [\App\Http\Controllers\frontend\AuthController::class, 'logout'])->name('logout');
    });
});

Route::get('/', [\App\Http\Controllers\frontend\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [\App\Http\Controllers\backend\LogController::class, 'index'])->name('admin.login.show');
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('user', \App\Http\Controllers\UserController::class);
        Route::post('user/{id}/lock', [\App\Http\Controllers\UserController::class, 'lock'])->name('user.lock');
        Route::get('admin-logout', [\App\Http\Controllers\backend\LogController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');

        Route::resource('category', \App\Http\Controllers\CategoryController::class);
        Route::post('category/update-with-log', [\App\Http\Controllers\CategoryController::class, 'updateWithLog'])->name('category.update.with.log');
        Route::post('category/delete-product', [\App\Http\Controllers\CategoryController::class, 'deleteProduct'])->name('category.delete.product');

        Route::resource('product', \App\Http\Controllers\ProductController::class);
        Route::put('product/update/detail/{product}', [\App\Http\Controllers\ProductController::class, 'updateDetal'])->name('product.update.detail');
    });
});
