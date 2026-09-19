<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\TryOnController;

// ========================================
// PUBLIC ROUTES
// ========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->middleware('throttle:5,1')->name('contact.send');

// ========================================
// CALCULATOR ROUTES (Public + Guest)
// ========================================
Route::prefix('calculator')->name('calculator.')->group(function () {
    Route::get('/chaddar', [\App\Http\Controllers\ChadarCalculatorController::class, 'index'])->name('chaddar');
    Route::post('/chaddar', [\App\Http\Controllers\ChadarCalculatorController::class, 'calculate'])->middleware('throttle:10,1')->name('chaddar.calculate');
    Route::get('/chaddar/result/{id}', [\App\Http\Controllers\ChadarCalculatorController::class, 'result'])->name('chaddar.result');
});

// ========================================
// MEEQAT ROUTES
// ========================================
Route::prefix('meeqat')->name('meeqat.')->group(function () {
    Route::get('/finder',          [\App\Http\Controllers\MeeqatController::class, 'index'])->name('finder');
    Route::post('/calculate',      [\App\Http\Controllers\MeeqatController::class, 'calculate'])->middleware('throttle:10,1')->name('calculate');
    Route::get('/result/{id}',     [\App\Http\Controllers\MeeqatController::class, 'result'])->name('result');
    Route::get('/locations',       [\App\Http\Controllers\MeeqatController::class, 'locations'])->name('locations');
    Route::post('/ajax-calculate', [\App\Http\Controllers\MeeqatController::class, 'ajaxCalculate'])->middleware('throttle:20,1')->name('ajax.calculate');
});

// ========================================
// DUAS & NIYAT ROUTES (Public)
// ========================================
Route::prefix('duas')->name('duas.')->group(function () {
    Route::get('/', [\App\Http\Controllers\DuaController::class, 'index'])->name('index');
    Route::get('/category/{slug}', [\App\Http\Controllers\DuaController::class, 'category'])->name('category');
    Route::get('/{id}', [\App\Http\Controllers\DuaController::class, 'show'])->name('show');
});

Route::prefix('niyat')->name('niyat.')->group(function () {
    Route::get('/', [\App\Http\Controllers\NiyatController::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\NiyatController::class, 'show'])->name('show');
});

// ========================================
// IHRAM GUIDE ROUTES (Public)
// ========================================
Route::prefix('ihram-guide')->name('ihram.')->group(function () {
    Route::get('/', [\App\Http\Controllers\IhramGuideController::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\IhramGuideController::class, 'show'])->name('show');
});

// ========================================
// NEW TOOLS ROUTES (Public)
// ========================================
Route::prefix('tools')->name('tools.')->group(function () {
    Route::get('/hajj-checklist', [\App\Http\Controllers\HomeController::class, 'hajjChecklist'])->name('hajj-checklist');
    Route::get('/qibla', [\App\Http\Controllers\HomeController::class, 'qibla'])->name('qibla');
    Route::get('/prayer-times', [\App\Http\Controllers\HomeController::class, 'prayerTimes'])->name('prayer-times');
});

// ========================================
// VIRTUAL TRY-ON ROUTES (Public)
// ========================================

Route::prefix('tryon')->name('tryon.')->group(function () {
    Route::get('/', [TryOnController::class, 'index'])->name('index'); // public: guests see Members-Only state

    // Members only
    Route::middleware('auth')->group(function () {
        Route::post('/generate', [TryOnController::class, 'generate'])->name('generate');
        Route::post('/ai-adjust', [TryOnController::class, 'aiAdjust'])->name('ai-adjust');
        Route::post('/save', [TryOnController::class, 'save'])->name('save');
        Route::post('/prompt', [TryOnController::class, 'prompt'])->name('prompt'); // internal prompt builder (silent fallback engine)
        Route::get('/history', [TryOnController::class, 'history'])->name('history');
        Route::delete('/history/{filename}', [TryOnController::class, 'deleteHistory'])->name('history.delete');
    });
});
// ========================================
// AUTHENTICATED USER ROUTES
// ========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // User Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\UserDashboardController::class, 'index'])->name('dashboard');

    // Bookmarks
    Route::post('/duas/bookmark/{id}', [\App\Http\Controllers\DuaController::class, 'bookmark'])->name('duas.bookmark');
    Route::delete('/duas/bookmark/{id}', [\App\Http\Controllers\DuaController::class, 'removeBookmark'])->name('duas.bookmark.remove');
    Route::get('/my-bookmarks', [\App\Http\Controllers\UserDashboardController::class, 'bookmarks'])->name('user.bookmarks');

    // History
    Route::get('/my-history', [\App\Http\Controllers\UserDashboardController::class, 'history'])->name('user.history');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================================
// ADMIN PANEL ROUTES
// ========================================
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Users (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', Admin\UserController::class);
        Route::patch('/users/{user}/toggle-status', [Admin\UserController::class, 'toggleStatus'])->name('users.toggle');
        Route::get('/analytics', [Admin\AnalyticsController::class, 'index'])->name('analytics');
        Route::get('/logs', [Admin\ActivityLogController::class, 'index'])->name('logs');
        Route::get('/settings', [Admin\SettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [Admin\SettingsController::class, 'update'])->name('settings.update');
    });

    // Content Management (Admin + Editor)
    Route::resource('duas', Admin\DuaController::class);
    Route::resource('niyat', Admin\NiyatController::class);
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('ihram-guides', Admin\IhramGuideController::class);
    Route::resource('products', Admin\ProductController::class);
    Route::resource('meeqat-locations', Admin\MeeqatLocationController::class);
    Route::resource('faqs', Admin\FaqController::class);

    // Messages
    Route::get('/messages', [Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [Admin\ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{id}', [Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');
});

// Auth Routes (Breeze)
require __DIR__.'/auth.php';