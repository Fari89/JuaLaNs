<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController; // Pastikan AdminController diimpor
use App\Http\Controllers\DashboardController; // Pastikan DashboardController diimpor

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// Rute Dashboard (membutuhkan autentikasi dan verifikasi email)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// --- Rute Admin (Sekarang dapat diakses tanpa login) ---
// Rute-rute ini telah dipindahkan keluar dari grup middleware 'auth'.
// Jika Anda ingin melindunginya, Anda perlu menambahkan middleware atau logika otorisasi kustom.
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
Route::get('/admin/{product}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/{product}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/{product}', [AdminController::class, 'destroy'])->name('admin.destroy');


// --- Rute yang Membutuhkan Autentikasi (untuk pengguna biasa) ---
// Grup middleware 'auth' memastikan semua rute di dalamnya hanya bisa diakses oleh pengguna yang sudah login.
Route::middleware('auth')->group(function () {
    // Rute untuk Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk Product (CRUD produk untuk pengguna/admin)
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('product.addToCart');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');


    // Routes untuk Cart (Keranjang Belanja)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
});

// Memuat rute autentikasi bawaan Laravel (login, register, reset password, dll.)
require __DIR__.'/auth.php';
