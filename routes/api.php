<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TechnologyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GrantController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\StatsController;

Route::prefix('v1')->group(function () {
    Route::get('/home', [StatsController::class, 'home']);
    // Auth Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/google-login', [AuthController::class, 'googleLogin']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/profile', [ProfileController::class, 'update']);
    });

    // Public Routes
    Route::get('/profiles/{user}', [ProfileController::class, 'show']);
    Route::get('/search', [SearchController::class, 'globalSearch']);

    // Module Routes
    Route::apiResource('technologies', TechnologyController::class)->only(['index', 'show']);
    Route::apiResource('grants', GrantController::class)->only(['index', 'show']);
    Route::apiResource('news', NewsController::class)->only(['index', 'show']);
});
