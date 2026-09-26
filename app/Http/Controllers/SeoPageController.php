<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use App\Services\ContentDiscovery;
use App\Services\ProductCatalog;
use Illuminate\Contracts\View\View;

class SeoPageController extends Controller
{
    public function __construct(
        private readonly ProductCatalog $products,
        private readonly ContentDiscovery $contentDiscovery,
    ) {}

    public function show(SeoPage $seoPage): View
    {
        abort_unless($seoPage->status === 'published' && $seoPage->published_at?->lte(now()), 404);

        $relatedProducts = collect($seoPage->related_product_slugs ?? [])
            ->map(fn (string $slug) => $this->products->find($slug))
            ->filter()
            ->values();
        $relatedContent = $this->contentDiscovery->forService($seoPage->slug);

        return view('seo-pages.show', [
            'seoPage' => $seoPage,
            'relatedProducts' => $relatedProducts,
            'relatedGuides' => $relatedContent['guides'],
            'meta' => [
                'title' => $seoPage->meta_title ?: $seoPage->title.' | BusinessOS',
                'description' => $seoPage->meta_description ?: $seoPage->excerpt,
                'canonical' => route('seo-pages.show', $seoPage),
            ],
            'schema' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => $seoPage->title,
                    'description' => $seoPage->excerpt,
                    'url' => route('seo-pages.show', $seoPage),
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => 'BusinessOS',
                        'url' => route('home'),
                        'logo' => url('assets/brand/businessos-logo.svg'),
                    ],
                ],
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => collect($seoPage->faq ?? [])->map(fn (array $item) => [
                        '@type' => 'Question',
                        'name' => $item['question'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['answer']],
                    ])->all(),
                ],
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => route('services')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $seoPage->title, 'item' => route('seo-pages.show', $seoPage)],
                    ],
                ],
            ],
        ]);
    }
}
