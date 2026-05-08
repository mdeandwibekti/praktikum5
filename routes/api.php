<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;

// Route Login untuk mendapatkan token
Route::post('/login', [AuthController::class, 'getToken']);

// Routes yang Public (Bisa diakses tanpa token)
Route::get('/product', [ProductApiController::class, 'index']);
Route::get('/product/{id}', [ProductApiController::class, 'show']);

// Routes yang Protected (Harus menyertakan Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    
    // CRUD Kategori (Semua route kategori diproteksi sesuai instruksi)
    Route::get('/category', [CategoryApiController::class, 'index']);
    Route::post('/category', [CategoryApiController::class, 'store']);
    Route::put('/category/{id}', [CategoryApiController::class, 'update']);
    Route::delete('/category/{id}', [CategoryApiController::class, 'destroy']);

    // Modifikasi Produk (Hanya POST, PUT, DELETE yang diproteksi)
    Route::post('/product', [ProductApiController::class, 'store']);
    Route::put('/product/{id}', [ProductApiController::class, 'update']);
    Route::delete('/product/{id}', [ProductApiController::class, 'destroy']);
    
});