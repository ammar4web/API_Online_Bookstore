<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth:sanctum', 'can:update-books'])->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::apiResource('/books', BookController::class);
});
