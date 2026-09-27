<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use App\Services\ContentDiscovery;
use App\Services\ProductCatalog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SeoPageController extends Controller
{
    public function __construct(
        private readonly ProductCatalog $products,
        private readonly ContentDiscovery $contentDiscovery,
    ) {}

    public function show(SeoPage $seoPage): View|RedirectResponse
    {
        if ($seoPage->usesRootCanonical()) {
            return redirect()->to($seoPage->publicUrl(), 301);
        }

        return $this->render($seoPage);
    }

    public function businessOperatingSystem(): View
    {
        return $this->render($this->publishedPage('business-operating-system-afghanistan'));
    }

    public function businessSoftwareAfghanistan(): View
    {
        return $this->render($this->publishedPage('business-software-afghanistan'));
    }

    private function publishedPage(string $slug): SeoPage
    {
        $page = SeoPage::query()->where('slug', $slug)->firstOrFail();

        abort_unless($page->status === 'published' && $page->published_at?->lte(now()), 404);

        return $page;
    }

    private function render(SeoPage $seoPage): View
    {
        abort_unless($seoPage->status === 'published' && $seoPage->published_at?->lte(now()), 404);

        $canonical = $seoPage->publicUrl();
        $relatedProducts = collect($seoPage->related_product_slugs ?? [])
            ->map(fn (string $slug) => $this->products->find($slug))
            ->filter()
            ->values();
        $relatedContent = $this->contentDiscovery->forService($seoPage->slug);

        $serviceSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $seoPage->title,
            'description' => $seoPage->excerpt,
            'url' => $canonical,
            'mainEntityOfPage' => $canonical,
            'serviceType' => $seoPage->title,
            'keywords' => implode(', ', $seoPage->target_keywords ?? []),
            'inLanguage' => app()->getLocale(),
            'isPartOf' => [
                '@type' => 'WebSite',
                'name' => 'BusinessOS',
                'url' => route('home'),
            ],
            'provider' => [
                '@type' => 'Organization',
                '@id' => route('home').'#organization',
                'name' => 'BusinessOS',
                'url' => route('home'),
                'logo' => url('assets/brand/businessos-logo.svg'),
            ],
        ];

        if (str_contains($seoPage->slug, 'afghanistan')) {
            $serviceSchema['areaServed'] = [
                '@type' => 'Country',
                'name' => 'Afghanistan',
            ];
            $serviceSchema['availableLanguage'] = ['English', 'Dari', 'Pashto'];
        }

        return view('seo-pages.show', [
            'seoPage' => $seoPage,
            'relatedProducts' => $relatedProducts,
            'relatedGuides' => $relatedContent['guides'],
            'meta' => [
                'title' => $seoPage->meta_title ?: $seoPage->title.' | BusinessOS',
                'description' => $seoPage->meta_description ?: $seoPage->excerpt,
                'canonical' => $canonical,
            ],
            'schema' => [
                $serviceSchema,
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
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $seoPage->title, 'item' => $canonical],
                    ],
                ],
            ],
        ]);
    }

}
