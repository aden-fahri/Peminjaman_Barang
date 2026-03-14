<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'userAkses:admin,staf,peminjam'])
    ->name('dashboard');

Route::get('/admin-only', function () {
    return 'Halaman khusus Admin';
})->middleware(['auth', 'userAkses:admin']);

Route::middleware('userAkses:admin')->group(function () {
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
    Route::patch('/admin/manage-users/{id}', [AdminController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::delete('/admin/manage-users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});

Route::middleware(['auth', 'userAkses:admin,staf'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);

    //loans
    Route::get('/loans/pending', [LoanController::class, 'pending'])->name('loans.pending');
    Route::post('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::post('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
    Route::post('/loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');
});

Route::middleware('auth')->group(function () {
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create/{itemId}', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
});