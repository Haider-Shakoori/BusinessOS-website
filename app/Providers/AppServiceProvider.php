<?php

namespace App\Providers;

use App\Services\ProductCatalog;
use App\Services\SiteSettings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(SiteSettings $settings, ProductCatalog $products): void
    {
        View::share('siteSettings', $settings);

        View::composer('layouts.marketing', function ($view) use ($products): void {
            $view->with('navProducts', $products->all());
        });
    }
}
