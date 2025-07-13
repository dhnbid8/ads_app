<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;

Route::prefix('api/v1')->group(function () {
    Route::get('ads', [AdController::class, 'index']);
    Route::get('ads/stats', [AdController::class, 'stats']);
    Route::get('ads/{ad}', [AdController::class, 'show']);
});