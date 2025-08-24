<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\ReportController;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', ProductController::class);
    
    // Clients
    Route::resource('clients', ClientController::class);
    
    // Purchases
    Route::resource('purchases', PurchaseController::class);
    
    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('reports/clients', [ReportController::class, 'clients'])->name('reports.clients');
    Route::get('reports/export-products', [ReportController::class, 'exportProducts'])->name('reports.export-products');
});

// Authentication routes (if using Laravel Breeze)
require __DIR__.'/auth.php';
