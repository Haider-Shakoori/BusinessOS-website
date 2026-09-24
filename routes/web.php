<?php

use App\Http\Controllers\MarketingController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketingController::class, 'home'])->name('home');

Route::get('/apps', [MarketingController::class, 'apps'])->name('apps.index');
Route::get('/apps/{slug}', [MarketingController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('apps.show');

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
