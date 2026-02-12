<?php

use App\Http\Controllers\Api\CoverageApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('coverage')->group(function () {
    Route::post('/check', [CoverageApiController::class, 'checkCoverage']);
    Route::get('/history', [CoverageApiController::class, 'getCoverageHistory']);
    Route::get('/governorates', [CoverageApiController::class, 'getGovernorates']);
    Route::get('/service-types', [CoverageApiController::class, 'getServiceTypes']);
});
