<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\OltController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/dashboard');

// =========================
// Dashboard Routes
// =========================
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/refresh-data', [DashboardController::class, 'refreshData'])->name('refresh');
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/fintech', [DashboardController::class, 'fintech'])->name('fintech');
});

// =========================
// OLT Routes (CRUD + Database Management)
// =========================
Route::resource('olt', OltController::class)->names([
    'index'   => 'olt.index',
    'create'  => 'olt.create',
    'store'   => 'olt.store',
    'show'    => 'olt.show',
    'edit'    => 'olt.edit',
    'update'  => 'olt.update',
    'destroy' => 'olt.destroy',
]);

// =========================
// Pelanggan Routes (CRUD)
// =========================
Route::resource('pelanggan', PelangganController::class)->names([
    'index'   => 'pelanggan.index',
    'create'  => 'pelanggan.create',
    'store'   => 'pelanggan.store',
    'show'    => 'pelanggan.show',
    'edit'    => 'pelanggan.edit',
    'update'  => 'pelanggan.update',
    'destroy' => 'pelanggan.destroy',
]);

// =========================
// Additional OLT Routes (Optional)
// =========================
Route::prefix('olt')->name('olt.')->group(function () {
    // Sync ONU data from specific OLT
    Route::post('{olt}/sync', [OltController::class, 'syncOnu'])->name('sync');
    
    // Test connection to OLT
    Route::post('{olt}/test-connection', [OltController::class, 'testConnection'])->name('test');
    
    // View OLT statistics
    Route::get('{olt}/statistics', [OltController::class, 'statistics'])->name('statistics');
    
    // Export pelanggan data from OLT database
    Route::get('{olt}/export', [OltController::class, 'exportPelanggan'])->name('export');
});