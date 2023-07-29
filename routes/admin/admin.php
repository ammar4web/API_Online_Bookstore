<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth:sanctum', 'can:update-books'])->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
});
