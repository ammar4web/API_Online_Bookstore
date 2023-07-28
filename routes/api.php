<?php

use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\PublisherController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/search', [GalleryController::class, 'search'])->name('search');

Route::get('/book/{book}', [BookController::class, 'details'])->name('book.details');

Route::get('/categories', [CategoryController::class, 'list'])->name('gallery.categories.index');
Route::get('/categories/search', [CategoryController::class, 'search'])->name('gallery.categories.search');
Route::get('/categories/{category}', [CategoryController::class, 'result'])->name('gallery.categories.show');

Route::get('/publishers', [PublisherController::class, 'list'])->name('gallery.publishers.index');
Route::get('/publishers/search', [PublisherController::class, 'search'])->name('gallery.publishers.search');
Route::get('/publishers/{publisher}', [PublisherController::class, 'result'])->name('gallery.publishers.show');

require __DIR__.'/auth/auth.php';
