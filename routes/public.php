<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\PublisherController;
use Illuminate\Support\Facades\Route;


Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/search', [GalleryController::class, 'search'])->name('search');

Route::get('/book/{book}', [BookController::class, 'details'])->name('book.details');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/book/{book}/rate', [BookController::class, 'rate'])->name('book.rate');
});


Route::get('/categories', [CategoryController::class, 'list'])->name('gallery.categories.index');
Route::get('/categories/search', [CategoryController::class, 'search'])->name('gallery.categories.search');
Route::get('/categories/{category}', [CategoryController::class, 'result'])->name('gallery.categories.show');

Route::get('/publishers', [PublisherController::class, 'list'])->name('gallery.publishers.index');
Route::get('/publishers/search', [PublisherController::class, 'search'])->name('gallery.publishers.search');
Route::get('/publishers/{publisher}', [PublisherController::class, 'result'])->name('gallery.publishers.show');

Route::get('/authors', [AuthorController::class, 'list'])->name('gallery.authors.index');
Route::get('/authors/search', [AuthorController::class, 'search'])->name('gallery.authors.search');
Route::get('/authors/{author}', [AuthorController::class, 'result'])->name('gallery.authors.show');
