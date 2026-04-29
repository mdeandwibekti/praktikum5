<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// 1. Route Publik (Tanpa Login)
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/about', [ProfileController::class, 'about']);

// 2. Route yang Butuh Login (Semua User: Admin & User Biasa)
Route::middleware('auth')->group(function () {
    
    // Dashboard & Profile
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- PERBAIKAN DI SINI ---
    // Semua user yang sudah login boleh melihat daftar dan detail produk
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');

    // 3. Khusus Aksi Manipulasi Data (Hanya Admin / Gate manage-product)
    Route::middleware('can:manage-product')->group(function () {
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    });

    // Route show harus setelah middleware routes agar tidak conflict dengan create dan edit
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

});

require __DIR__.'/auth.php';