<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AvailabilityCheckController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceAvailabilityController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\Admin\StatusHistoryController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/check-availability', [AvailabilityCheckController::class, 'index'])->name('check.index');
Route::post('/check-availability', [AvailabilityCheckController::class, 'check'])->name('check.availability');

// Admin routes (protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Service Availability routes
    Route::get('/service-availability/export', [ServiceAvailabilityController::class, 'export'])->name('service-availability.export');
    Route::post('/service-availability/quick-update', [ServiceAvailabilityController::class, 'quickUpdate'])->name('service-availability.quick-update');
    Route::post('/service-availability/bulk-update', [ServiceAvailabilityController::class, 'bulkUpdate'])->name('service-availability.bulk-update');
    Route::resource('service-availability', ServiceAvailabilityController::class);
    
    // Area routes
    Route::resource('areas', AreaController::class);
    
    // Service Type routes
    Route::resource('service-types', ServiceTypeController::class);
    
    // Status History routes
    Route::get('/status-history', [StatusHistoryController::class, 'index'])->name('status-history.index');
    Route::get('/status-history/export', [StatusHistoryController::class, 'export'])->name('status-history.export');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
