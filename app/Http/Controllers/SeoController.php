<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Services\ProductCatalog;
use Illuminate\Http\Response;
use Throwable;

class SeoController extends Controller
{
    public function __construct(private readonly ProductCatalog $products) {}

    public function sitemap(): Response
    {
        $urls = collect([
            ['loc' => route('home'), 'lastmod' => now()->toDateString(), 'priority' => '1.0'],
            ['loc' => route('apps.index'), 'lastmod' => now()->toDateString(), 'priority' => '0.9'],
            ['loc' => route('services'), 'lastmod' => now()->toDateString(), 'priority' => '0.9'],
            ['loc' => route('resources.index'), 'lastmod' => now()->toDateString(), 'priority' => '0.8'],
            ['loc' => route('pricing'), 'lastmod' => now()->toDateString(), 'priority' => '0.8'],
            ['loc' => route('about'), 'lastmod' => now()->toDateString(), 'priority' => '0.7'],
            ['loc' => route('security'), 'lastmod' => now()->toDateString(), 'priority' => '0.6'],
            ['loc' => route('contact'), 'lastmod' => now()->toDateString(), 'priority' => '0.6'],
            ['loc' => route('privacy'), 'lastmod' => now()->toDateString(), 'priority' => '0.3'],
            ['loc' => route('terms'), 'lastmod' => now()->toDateString(), 'priority' => '0.3'],
        ])->merge(
            $this->products->all()->map(fn (array $app) => [
                'loc' => route('apps.show', $app['slug']),
                'lastmod' => $app['updated_at'] ?? now()->toDateString(),
                'priority' => '0.9',
            ])
        );

        try {
            $urls = $urls->merge(
                Guide::published()
                    ->latest('updated_at')
                    ->get()
                    ->map(fn (Guide $guide) => [
                        'loc' => route('resources.show', ['guide' => $guide->slug]),
                        'lastmod' => $guide->updated_at?->toDateString() ?? now()->toDateString(),
                        'priority' => '0.7',
                    ])
            );
        } catch (Throwable) {
            // Keep the static sitemap available before first migration.
        }

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $body = "User-agent: *\nAllow: /\nDisallow: /admin\n\nSitemap: ".route('sitemap')."\n";

        return response($body, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
