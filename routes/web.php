<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;


// --- Rute Publik (Akses Tanpa Login) ---
// Rute utama website
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk melihat daftar produk
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

// Rute untuk melihat isi keranjang belanja
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Rute untuk melihat halaman checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
// Rute Dashboard (sekarang dilindungi autentikasi)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Rute Admin (CRUD Produk oleh Admin) ---
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{product}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{product}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{product}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // --- Rute Profil Pengguna ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Rute Interaksi Keranjang Belanja ---
    Route::post('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('product.addToCart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    // --- Rute Proses Checkout ---
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    
    Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
});

// --- Rute yang Membutuhkan Autentikasi (Harus Login) ---
// Semua rute di dalam grup ini akan memerlukan pengguna untuk login terlebih dahulu.
// Jika belum login, Laravel akan mengarahkan ke halaman login.
Route::middleware('auth')->group(function () {

    // --- Rute CRUD Produk (Pengelola/Admin) ---
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});


// Memuat rute autentikasi bawaan Laravel (seperti /login, /register, /logout)
require __DIR__.'/auth.php';