<?php

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketingController::class, 'home'])->name('home');

Route::get('/apps', [MarketingController::class, 'apps'])->name('apps.index');
Route::get('/apps/{slug}', [MarketingController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('apps.show');

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

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
