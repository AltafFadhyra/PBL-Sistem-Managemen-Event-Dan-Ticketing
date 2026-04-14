<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

// Controller (Bagian A)
Route::get('/produk', [ProdukController::class, 'tampilkan']);

// View (Bagian B)
Route::view('/home', 'home');
Route::view('/about', 'about');
Route::view('/product', 'product');
Route::view('/contact', 'contact');
Route::view('/login', 'login');
Route::view('/register', 'register');
Route::view('/dashboard', 'dashboard');