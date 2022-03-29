<?php

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

Route::prefix('user')->group(function () {
    Route::post('/update', [App\Http\Controllers\Ajax\UserController::class, 'update'])->name('ajax.user.update');
    Route::post('/unique-name', [App\Http\Controllers\Ajax\UserController::class, 'validateUniqueName'])->name('ajax.user.validate.unique.name');
    Route::post('/unique-email', [App\Http\Controllers\Ajax\UserController::class, 'validateUniqueEmail'])->name('ajax.user.validate.unique.email');
});

Route::prefix('category')->group(function () {
    Route::post('/unique-name', [App\Http\Controllers\Ajax\CategoryController::class, 'validateUniqueName'])->name('ajax.category.validate.unique.name');
    Route::get('/autocomplete', [App\Http\Controllers\Ajax\CategoryController::class, 'autocomplete'])->name('ajax.category.autocomplete');
});

Route::prefix('product')->group(function () {
    Route::post('/unique-name', [App\Http\Controllers\Ajax\ProductController::class, 'validateUniqueName'])->name('ajax.product.validate.unique.name');
    Route::post('/unique-code', [App\Http\Controllers\Ajax\ProductController::class, 'validateUniqueCode'])->name('ajax.product.validate.unique.code');
});

Route::prefix('attachment')->group(function () {
    Route::post('/upload', [App\Http\Controllers\Ajax\AttachmentController::class, 'upload'])->name('ajax.attachment.upload');
    Route::post('/local', [App\Http\Controllers\Ajax\AttachmentController::class, 'uploadLocal'])->name('ajax.attachment.upload.local');
    Route::post('/delete-attachment', [App\Http\Controllers\Ajax\AttachmentController::class, 'deleteAttachment'])->name('ajax.attachment.delete.attachment');
});
