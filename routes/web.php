<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AltafController;

Route::get('/altaf', [AltafController::class, 'tampilkan']);

use App\Http\Controllers\ProductController;

// Route yang merujuk ke ProductController dengan method 'index'
Route::get('/produk', [ProductController::class, 'index']);
