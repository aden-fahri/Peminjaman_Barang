<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

// Halaman utama (bisa welcome atau langsung redirect ke login)
Route::get('/', function () {
    return redirect('/login');
});

// Auth routes
Route::get('/login', [SessionController::class, 'index'])->name('login');
Route::post('/login', [SessionController::class, 'login']);
Route::get('/register', [SessionController::class, 'register'])->name('register');
Route::post('/register', [SessionController::class, 'store']);

// Logout (harus login dulu)
Route::post('/logout', [SessionController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard contoh
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'userAkses:admin,staf,peminjam'])->name('dashboard');

Route::get('/admin-only', function () {
    return 'Halaman khusus Admin';
})->middleware(['auth', 'userAkses:admin']);


Route::middleware(['auth', 'userAkses:admin,staf'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);
});