<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\PublisherController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth:sanctum', 'can:update-books'])->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/books/book-form-data', [BookController::class, 'getBookFormData'])->name('books.getBookFormData');
    Route::apiResource('/books', BookController::class);
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/publishers', PublisherController::class);
});
