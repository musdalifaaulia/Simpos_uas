<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\ExpenseController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::post('/switch-user', [LoginController::class, 'switchUser'])->name('login.switch_user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/show', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('/dashboard/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/update', [DashboardController::class, 'update'])->name('dashboard.update');

    Route::resource('/user', UserController::class)->middleware('role:Superadmin');
    Route::resource('/branch', BranchController::class)->middleware('role:Superadmin');
    Route::resource('/category', CategoryController::class)->middleware('role:Superadmin');
    Route::resource('/product', ProductController::class)->middleware('role:Superadmin');
    Route::resource('/inventory', InventoryController::class)->middleware('role:Superadmin,Admin');
    Route::resource('/transaction', TransactionController::class);
    Route::resource('/stock-transfer', StockTransferController::class)->middleware('role:Superadmin,Admin');
    Route::resource('/expense', ExpenseController::class)->middleware('role:Superadmin,Admin');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index')->middleware('role:Superadmin');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update')->middleware('role:Superadmin');
});
