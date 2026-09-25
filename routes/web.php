<?php

use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CaseStudyController as AdminCaseStudyController;
use App\Http\Controllers\Admin\GuideController as AdminGuideController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SeoPageController as AdminSeoPageController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\SeoPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketingController::class, 'home'])->name('home');

Route::get('/services', [MarketingController::class, 'services'])->name('services');
Route::get('/services/{seoPage:slug}', [SeoPageController::class, 'show'])
    ->where('seoPage', '[a-z0-9-]+')
    ->name('seo-pages.show');

Route::get('/apps', [MarketingController::class, 'apps'])->name('apps.index');
Route::get('/apps/{slug}', [MarketingController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('apps.show');

Route::get('/resources', [GuideController::class, 'index'])->name('resources.index');
Route::get('/case-studies', [CaseStudyController::class, 'index'])->name('case-studies.index');
Route::get('/case-studies/{caseStudy:slug}', [CaseStudyController::class, 'show'])
    ->where('caseStudy', '[a-z0-9-]+')
    ->name('case-studies.show');
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
    Route::post('/analytics/exclude-browser', [AdminAnalyticsController::class, 'excludeBrowser'])->name('analytics.exclude-browser');
    Route::post('/analytics/include-browser', [AdminAnalyticsController::class, 'includeBrowser'])->name('analytics.include-browser');
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('guides', AdminGuideController::class)->except(['show']);
    Route::resource('seo-pages', AdminSeoPageController::class)->except(['show']);
    Route::resource('case-studies', AdminCaseStudyController::class)->except(['show']);

    Route::get('/inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}', [AdminInquiryController::class, 'show'])->name('inquiries.show');
    Route::put('/inquiries/{inquiry}', [AdminInquiryController::class, 'update'])->name('inquiries.update');
    Route::post('/inquiries/{inquiry}/notes', [AdminInquiryController::class, 'storeNote'])->name('inquiries.notes.store');

    Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
    Route::post('/media', [AdminMediaController::class, 'store'])->name('media.store');
    Route::put('/media/{media}', [AdminMediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{media}', [AdminMediaController::class, 'destroy'])->name('media.destroy');

    Route::get('/settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');

    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
});

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/indexnow-key.txt', [SeoController::class, 'indexNowKey'])->name('indexnow.key');
