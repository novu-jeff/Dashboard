<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Transactions;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->to('/login');
});

// ------------------------
// Authentication
// ------------------------
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::get('/register', [RegisterController::class, 'showForm'])->name('auth.register');
Route::post('/register', [RegisterController::class, 'register'])->name('auth.register.store');

// ------------------------
// ADMIN ROUTES
// ------------------------
Route::prefix('admin')->middleware('auth:admins')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::prefix('transactions')->group(function () {
        Route::get('/', [Transactions::class, 'index'])
            ->name('admin.transactions.index');
        Route::get('/download', [Transactions::class, 'download'])
            ->name('admin.transactions.download');
    });

Route::prefix('admin')->middleware(['auth:admins', 'superadmin'])->group(function () {

    // Personnel management (CRUD)
    Route::get('personnel', [AdminController::class, 'index'])
        ->name('admin.personnel.index');

    Route::get('personnel/create', [AdminController::class, 'create'])
        ->name('admin.personnel.create');

    Route::post('personnel', [AdminController::class, 'store'])
        ->name('admin.personnel.store');

    Route::get('personnel/{admin}/edit', [AdminController::class, 'edit'])
        ->name('admin.personnel.edit');

    Route::put('personnel/{admin}', [AdminController::class, 'update'])
        ->name('admin.personnel.update');

    Route::delete('personnel/{admin}', [AdminController::class, 'destroy'])
        ->name('admin.personnel.destroy');

    Route::get('personnel/{admin}', [AdminController::class, 'show'])
        ->name('admin.personnel.show');
});

});
