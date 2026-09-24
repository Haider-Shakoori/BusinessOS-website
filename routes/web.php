<?php

use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\GuideController as AdminGuideController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketingController::class, 'home'])->name('home');

Route::get('/apps', [MarketingController::class, 'apps'])->name('apps.index');
Route::get('/apps/{slug}', [MarketingController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('apps.show');

Route::get('/resources', [GuideController::class, 'index'])->name('resources.index');
Route::get('/guides/{guide:slug}', [GuideController::class, 'show'])->name('resources.show');

Route::get('/pricing', [MarketingController::class, 'pricing'])->name('pricing');
Route::get('/about', [MarketingController::class, 'about'])->name('about');
Route::get('/security', [MarketingController::class, 'security'])->name('security');
Route::get('/privacy', [MarketingController::class, 'privacy'])->name('privacy');
Route::get('/terms', [MarketingController::class, 'terms'])->name('terms');
Route::get('/contact', [MarketingController::class, 'contact'])->name('contact');
Route::get('/request-demo', [MarketingController::class, 'demo'])->name('demo');
Route::post('/contact', [InquiryController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('inquiries.store');

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminAnalyticsController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics');
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('guides', AdminGuideController::class)->except(['show']);
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
});

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
