<?php

use App\Http\Controllers\Api\CoverageController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public coverage check endpoints
    Route::post('/coverage/check', [CoverageController::class, 'check']);
    Route::get('/coverage/governorate/{code}', [CoverageController::class, 'getByGovernorate']);
    Route::get('/coverage/history', [CoverageController::class, 'history']);
    
    // Statistics endpoints
    Route::get('/coverage/stats', [CoverageController::class, 'statistics']);
    Route::get('/coverage/compare', [CoverageController::class, 'compare']);
});
