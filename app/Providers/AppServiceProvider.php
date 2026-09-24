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

[executed on device: ubuntu-6gb-dal-x8mx (c447f909-fdcc-4121-9924-27a69d35e9b2)]