<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Guide;
use App\Models\SeoPage;
use App\Services\ProductCatalog;
use Illuminate\Http\Response;
use Throwable;

class SeoController extends Controller
{
    public function __construct(private readonly ProductCatalog $products) {}

    public function sitemap(): Response
    {
        $urls = collect([
            ['loc' => route('home'), 'lastmod' => now()->toDateString(), 'priority' => '1.0', 'localized' => true],
            ['loc' => route('apps.index'), 'lastmod' => now()->toDateString(), 'priority' => '0.9'],
            ['loc' => route('services'), 'lastmod' => now()->toDateString(), 'priority' => '0.9'],
            ['loc' => route('resources.index'), 'lastmod' => now()->toDateString(), 'priority' => '0.8'],
            ['loc' => route('case-studies.index'), 'lastmod' => now()->toDateString(), 'priority' => '0.8'],
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
                'localized' => (bool) ($app['has_localized_content'] ?? false),
                'images' => collect($app['screenshots'] ?? [])
                    ->map(function (mixed $item) use ($app): array {
                        $rawUrl = is_array($item) ? trim((string) ($item['url'] ?? '')) : trim((string) $item);
                        $alt = is_array($item) ? trim((string) ($item['alt'] ?? '')) : '';
                        $caption = is_array($item) ? trim((string) ($item['caption'] ?? '')) : '';

                        return [
                            'loc' => $rawUrl === '' ? '' : (str_starts_with($rawUrl, 'http://') || str_starts_with($rawUrl, 'https://') ? $rawUrl : url($rawUrl)),
                            'title' => $alt ?: $app['name'].' interface screenshot',
                            'caption' => $caption,
                        ];
                    })
                    ->filter(fn (array $image) => $image['loc'] !== '')
                    ->values()
                    ->all(),
            ])
        );

        try {
            $urls = $urls
                ->merge(SeoPage::published()->latest('updated_at')->get()->map(fn (SeoPage $page) => [
                    'loc' => route('seo-pages.show', $page),
                    'lastmod' => $page->updated_at?->toDateString() ?? now()->toDateString(),
                    'priority' => '0.9',
                ]))
                ->merge(Guide::published()->latest('updated_at')->get()->map(fn (Guide $guide) => [
                    'loc' => route('resources.show', $guide),
                    'lastmod' => $guide->updated_at?->toDateString() ?? now()->toDateString(),
                    'priority' => '0.7',
                ]))
                ->merge(CaseStudy::published()->latest('updated_at')->get()->map(fn (CaseStudy $caseStudy) => [
                    'loc' => route('case-studies.show', $caseStudy),
                    'lastmod' => $caseStudy->updated_at?->toDateString() ?? now()->toDateString(),
                    'priority' => '0.8',
                ]));
        } catch (Throwable) {
            // Keep the static sitemap available before first migration.
        }

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $body = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            '',
            'User-agent: OAI-SearchBot',
            'Allow: /',
            'Disallow: /admin',
            '',
            'User-agent: PerplexityBot',
            'Allow: /',
            'Disallow: /admin',
            '',
            'User-agent: GPTBot',
            'Allow: /',
            'Disallow: /admin',
            '',
            'Sitemap: '.route('sitemap'),
            '',
        ]);

        return response($body, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function indexNowKey(): Response
    {
        $key = trim((string) config('search.indexnow.key'));

        abort_if($key === '' || ! config('search.indexnow.enabled'), 404);

        return response($key, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
