<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExchangeRequestController;
use App\Http\Controllers\GrantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/search', \App\Http\Controllers\SearchController::class)->name('search');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('technologies', \App\Http\Controllers\TechnologyController::class);
    Route::post('ai/analyze', [\App\Http\Controllers\TechnologyController::class, 'aiAnalyze'])->name('ai.analyze');
    
    Route::get('/scientists', [\App\Http\Controllers\ScientistController::class, 'index'])->name('scientists.index');
    Route::get('/scientists/{scientist}', [\App\Http\Controllers\ScientistController::class, 'show'])->name('scientists.show');
    
    Route::get('/marketplace', [\App\Http\Controllers\MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::get('/grants', [GrantController::class, 'index'])->name('grants.index');
    Route::get('/requests', [ExchangeRequestController::class, 'index'])->name('requests.index');
    Route::post('/requests', [ExchangeRequestController::class, 'store'])->name('requests.store');
});

Route::middleware(['auth', 'verified', 'agency'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/organizations', [AdminController::class, 'storeOrganization'])->name('organizations.store');
    Route::patch('/organizations/{organization}/verify', [AdminController::class, 'verifyOrganization'])->name('organizations.verify');
    Route::post('/grants', [AdminController::class, 'storeGrant'])->name('grants.store');
    Route::patch('/users/{user}/assign-scientist', [AdminController::class, 'assignScientist'])->name('users.assign-scientist');
    Route::patch('/users/{user}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
    Route::patch('/users/{user}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');
});

Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::get('lang/{locale}', \App\Http\Controllers\LocaleController::class)->name('lang.switch');

require __DIR__.'/auth.php';
