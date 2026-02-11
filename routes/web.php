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
    Route::get('/services/export', [ServiceAvailabilityController::class, 'export'])->name('services.export');
    Route::post('/services/quick-update', [ServiceAvailabilityController::class, 'quickUpdate'])->name('services.quick-update');
    Route::post('/services/bulk-update', [ServiceAvailabilityController::class, 'bulkUpdate'])->name('services.bulk-update');
    Route::resource('services', ServiceAvailabilityController::class);
    
    // Area routes
    Route::resource('areas', AreaController::class);
    
    // Service Type routes
    Route::resource('service-types', ServiceTypeController::class);
    
    // Status History routes
    Route::get('/history', [StatusHistoryController::class, 'index'])->name('history.index');
    Route::get('/history/export', [StatusHistoryController::class, 'export'])->name('history.export');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
