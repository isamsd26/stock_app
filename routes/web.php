<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProfileController;

/*
|----------------------------------------------------------
| Public (welcome/landing)
|----------------------------------------------------------
*/

Route::get('/', function () {
    // Bisa landing page, atau langsung redirect ke dashboard
    return redirect()->route('dashboard');
});

/*
|----------------------------------------------------------
| Dashboard (butuh auth & verified)
|----------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|----------------------------------------------------------
| Authenticated area
|----------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === Master Data ===
    Route::resource('categories', CategoryController::class);
    Route::resource('products',   ProductController::class);
    Route::resource('suppliers',  SupplierController::class)->except(['show']);

    // === Transaksi ===
    Route::get('transactions/history', [StockController::class, 'history'])->name('transactions.history');
    Route::post('stock-in',    [StockController::class, 'storeIn'])->name('stock.in.store');
    Route::post('stock-out',   [StockController::class, 'storeOut'])->name('stock.out.store');
    Route::post('stock-adjust', [StockController::class, 'storeAdjust'])->name('stock.adjust.store');

    // === Laporan ===
    Route::get('reports/stock',       [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('reports/movement',    [ReportController::class, 'movement'])->name('reports.movement');
    Route::get('reports/adjustments', [ReportController::class, 'adjustments'])->name('reports.adjustments');

    // === Pengaturan ===
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'store'])->name('settings.store');
});

require __DIR__ . '/auth.php';
