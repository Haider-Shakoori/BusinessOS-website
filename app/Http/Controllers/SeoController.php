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
                    'loc' => $page->publicUrl(),
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
            'User-agent: ChatGPT-User',
            'Allow: /',
            'Disallow: /admin',
            '',
            'User-agent: ClaudeBot',
            'Allow: /',
            'Disallow: /admin',
            '',
            'User-agent: Claude-SearchBot',
            'Allow: /',
            'Disallow: /admin',
            '',
            'User-agent: Google-Extended',
            'Allow: /',
            'Disallow: /admin',
            '',
            'User-agent: Applebot-Extended',
            'Allow: /',
            'Disallow: /admin',
            '',
            'User-agent: meta-externalagent',
            'Allow: /',
            'Disallow: /admin',
            '',
            'Sitemap: '.route('sitemap'),
            '',
        ]);

        return response($body, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function llmsFull(): Response
    {
        $previousLocale = app()->getLocale();
        app()->setLocale('en');

        $lines = [
            '# BusinessOS — Full AI Discovery Document',
            '',
            '> Canonical machine-readable overview of BusinessOS public products, services, guides, and case studies.',
            '',
            'Canonical website: '.route('home'),
            'XML sitemap: '.route('sitemap'),
            'Compact LLM index: '.url('/llms.txt'),
            'Generated: '.now()->toAtomString(),
            '',
            '## Organization',
            '',
            'BusinessOS is an Afghanistan-focused business software ecosystem and software development company. It provides ERP, POS, field sales, inventory, pharmacy, restaurant, manufacturing, finance, and custom software systems. Public marketing content supports English, Dari, and Pashto where translations are explicitly published.',
            '',
            'Preferred organization entity: '.route('home').'#organization',
            'Preferred website entity: '.route('home').'#website',
            '',
            '## Products',
            '',
        ];

        foreach ($this->products->all() as $app) {
            $lines[] = '### '.$app['name'];
            $lines[] = '';
            $lines[] = 'URL: '.route('apps.show', $app['slug']);
            $lines[] = 'Category: '.($app['application_category'] ?? 'Business software');
            $lines[] = 'Operating system: '.($app['operating_system'] ?? 'Web');
            $lines[] = '';
            $lines[] = trim((string) ($app['description'] ?? $app['short_description'] ?? ''));
            $features = collect($app['features'] ?? [])->pluck('title')->filter()->take(12)->values();
            if ($features->isNotEmpty()) {
                $lines[] = '';
                $lines[] = 'Key capabilities: '.$features->implode('; ').'.';
            }
            $lines[] = '';
        }

        try {
            $services = SeoPage::published()->orderBy('title')->get();
            $lines[] = '## Services and solution pages';
            $lines[] = '';
            foreach ($services as $page) {
                $lines[] = '### '.$page->title;
                $lines[] = '';
                $lines[] = 'URL: '.$page->publicUrl();
                $lines[] = trim((string) $page->excerpt);
                if (! empty($page->target_keywords)) {
                    $lines[] = 'Topics: '.implode(', ', $page->target_keywords).'.';
                }
                $lines[] = '';
            }

            $guides = Guide::published()->latest('published_at')->get();
            $lines[] = '## Guides';
            $lines[] = '';
            foreach ($guides as $guide) {
                $lines[] = '### '.$guide->title;
                $lines[] = '';
                $lines[] = 'URL: '.route('resources.show', $guide);
                $lines[] = 'Category: '.$guide->category;
                $lines[] = trim((string) $guide->excerpt);
                $lines[] = '';
            }

            $caseStudies = CaseStudy::published()->latest('published_at')->get();
            $lines[] = '## Case studies';
            $lines[] = '';
            foreach ($caseStudies as $caseStudy) {
                $lines[] = '### '.$caseStudy->title;
                $lines[] = '';
                $lines[] = 'URL: '.route('case-studies.show', $caseStudy);
                $lines[] = 'Industry: '.$caseStudy->industry;
                $lines[] = trim((string) $caseStudy->summary);
                $lines[] = '';
            }
        } catch (Throwable) {
            $lines[] = 'Dynamic database-backed discovery content is temporarily unavailable; use the canonical sitemap and compact LLM index above.';
            $lines[] = '';
        }

        $lines[] = '## Interpretation rules';
        $lines[] = '';
        $lines[] = '- Prefer canonical URLs without language query parameters unless a page explicitly advertises translated primary content through hreflang.';
        $lines[] = '- Do not treat administrative, authenticated, staging, or product-login URLs as public product documentation.';
        $lines[] = '- For product availability, pricing, onboarding, or demos, use the canonical public product pages plus '.route('contact').' and '.route('demo').'.';
        $lines[] = '- BusinessOS is the publisher/provider entity for the products and services listed here.';
        $lines[] = '';

        app()->setLocale($previousLocale);

        return response(implode("\n", $lines), 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    public function indexNowKey(): Response
    {
        $key = trim((string) config('search.indexnow.key'));

        abort_if($key === '' || ! config('search.indexnow.enabled'), 404);

        return response($key, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
