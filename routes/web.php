<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// ================= PUBLIC =================
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/about', [ProfileController::class, 'about']);


// ================= AUTH =================
Route::middleware('auth')->group(function () {

    // ===== Dashboard =====
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ===== Profile =====
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ================= PRODUCT =================

    // List
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');

    // 🔥 PENTING: ROUTE SPESIFIK DULU
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');

    Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    // 🔥 TERAKHIR: ROUTE DINAMIS
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

});

require __DIR__.'/auth.php';