<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Guide;
use App\Models\SeoPage;
use App\Services\ContentDiscovery;
use App\Services\ProductCatalog;
use App\Services\SiteSettings;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Throwable;

class MarketingController extends Controller
{
    public function __construct(
        private readonly ProductCatalog $products,
        private readonly SiteSettings $settings,
        private readonly ContentDiscovery $contentDiscovery,
    ) {}

    public function home(): View
    {
        $apps = $this->products->homepage();
        $latestGuides = $this->latestGuides();
        $latestCaseStudies = $this->latestCaseStudies();
        $services = $this->localizedServices();
        $serviceFaqs = $this->localizedServiceFaqs();

        return view('home', [
            'apps' => $apps,
            'latestGuides' => $latestGuides,
            'latestCaseStudies' => $latestCaseStudies,
            'services' => $services,
            'serviceFaqs' => $serviceFaqs,
            'meta' => [
                'title' => app()->getLocale() === 'en'
                    ? $this->settings->get('seo_default_title', __('marketing.seo.home_title'))
                    : __('marketing.seo.home_title'),
                'description' => app()->getLocale() === 'en'
                    ? $this->settings->get('seo_default_description', __('marketing.seo.home_description'))
                    : __('marketing.seo.home_description'),
                'canonical' => route('home'),
                'localized' => true,
            ],
            'schema' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'Organization',
                    'name' => 'BusinessOS',
                    'url' => route('home'),
                    'logo' => url('assets/brand/businessos-logo.svg'),
                    'description' => config('businessos.brand.description'),
                    'knowsAbout' => $services->pluck('name')->values()->all(),
                    'hasOfferCatalog' => [
                        '@type' => 'OfferCatalog',
                        'name' => 'BusinessOS software development services',
                        'itemListElement' => $services->map(fn (array $service) => [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => $service['name'],
                                'description' => $service['short'],
                            ],
                        ])->values()->all(),
                    ],
                ],
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebSite',
                    'name' => 'BusinessOS',
                    'url' => route('home'),
                ],
            ],
        ]);
    }

    public function apps(): View
    {
        $apps = $this->products->all();

        return view('apps.index', [
            'apps' => $apps,
            'meta' => [
                'title' => __('marketing.meta.apps_title'),
                'description' => __('marketing.meta.apps_description'),
                'canonical' => route('apps.index'),
                'localized' => true,
            ],
            'schema' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'CollectionPage',
                    'name' => 'BusinessOS Apps',
                    'url' => route('apps.index'),
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'itemListElement' => $apps->values()->map(
                            fn (array $app, int $index) => [
                                '@type' => 'ListItem',
                                'position' => $index + 1,
                                'name' => $app['name'],
                                'url' => route('apps.show', $app['slug']),
                            ]
                        )->all(),
                    ],
                ],
            ],
        ]);
    }

    public function show(string $slug): View
    {
        $app = $this->products->find($slug);

        abort_unless($app, 404);

        $screenshots = collect($app['screenshots'] ?? [])
            ->map(function (mixed $item) use ($app): array {
                if (is_string($item)) {
                    return [
                        'url' => trim($item),
                        'alt' => $app['name'].' interface screenshot',
                        'caption' => '',
                    ];
                }

                return [
                    'url' => trim((string) ($item['url'] ?? '')),
                    'alt' => trim((string) ($item['alt'] ?? '')) ?: $app['name'].' interface screenshot',
                    'caption' => trim((string) ($item['caption'] ?? '')),
                ];
            })
            ->filter(fn (array $item) => $item['url'] !== '')
            ->values();

        $primaryScreenshot = $screenshots->first();
        $relatedContent = $this->contentDiscovery->forProduct($app['slug']);

        return view('apps.show', [
            'app' => $app,
            'relatedServices' => $relatedContent['services'],
            'relatedGuides' => $relatedContent['guides'],
            'relatedCaseStudies' => $relatedContent['caseStudies'],
            'meta' => [
                'title' => $app['seo']['title'],
                'description' => $app['seo']['description'],
                'canonical' => route('apps.show', $app['slug']),
                'localized' => (bool) ($app['has_localized_content'] ?? false),
                'image' => $primaryScreenshot['url'] ?? null,
                'image_alt' => $primaryScreenshot['alt'] ?? null,
            ],
            'schema' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'SoftwareApplication',
                    'name' => $app['name'],
                    'description' => $app['description'],
                    'url' => route('apps.show', $app['slug']),
                    'applicationCategory' => $app['application_category'],
                    'operatingSystem' => $app['operating_system'],
                    'screenshot' => $screenshots->pluck('url')->all(),
                    'featureList' => collect($app['features'] ?? [])->pluck('title')->filter()->values()->all(),
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'BusinessOS',
                        'url' => route('home'),
                        'logo' => url('assets/brand/businessos-logo.svg'),
                    ],
                ],
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Apps', 'item' => route('apps.index')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $app['name'], 'item' => route('apps.show', $app['slug'])],
                    ],
                ],
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => collect($app['faq'] ?? [])->map(fn (array $item) => [
                        '@type' => 'Question',
                        'name' => $item['question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $item['answer'],
                        ],
                    ])->all(),
                ],
            ],
        ]);
    }

    public function services(): View
    {
        $services = $this->localizedServices();
        $serviceFaqs = $this->localizedServiceFaqs();

        try {
            $searchPages = SeoPage::published()->orderBy('title')->get();
        } catch (Throwable) {
            $searchPages = collect();
        }

        return view('pages.services', [
            'services' => $services,
            'serviceFaqs' => $serviceFaqs,
            'searchPages' => $searchPages,
            'meta' => [
                'title' => __('marketing.meta.services_title'),
                'description' => __('marketing.meta.services_description'),
                'canonical' => route('services'),
                'localized' => true,
            ],
            'schema' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'CollectionPage',
                    'name' => 'BusinessOS Software Development Services',
                    'url' => route('services'),
                    'description' => 'Custom software development and modernization services from BusinessOS.',
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'itemListElement' => $services->values()->map(fn (array $service, int $index) => [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'item' => [
                                '@type' => 'Service',
                                'name' => $service['name'],
                                'description' => $service['description'],
                                'provider' => [
                                    '@type' => 'Organization',
                                    'name' => 'BusinessOS',
                                    'url' => route('home'),
                                    'logo' => url('assets/brand/businessos-logo.svg'),
                                ],
                            ],
                        ])->all(),
                    ],
                ],
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => route('services')],
                    ],
                ],
            ],
        ]);
    }

    public function pricing(): View
    {
        return view('pages.pricing', [
            ...$this->pageMeta(
                __('marketing.meta.pricing_title'),
                __('marketing.meta.pricing_description'),
                route('pricing')
            ),
            'apps' => $this->products->all(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            ...$this->pageMeta(
                __('marketing.meta.about_title'),
                __('marketing.meta.about_description'),
                route('about')
            ),
            'aboutTitle' => $this->settings->localized('about_title', 'Software shaped around the way businesses actually operate.'),
            'aboutLead' => $this->settings->localized('about_lead', 'BusinessOS is a growing software ecosystem focused on practical business workflows.'),
            'aboutBody' => $this->settings->localized('about_body', 'BusinessOS applications are built around clear operational problems.'),
        ]);
    }

    public function security(): View
    {
        return view('pages.security', $this->pageMeta(
            __('marketing.meta.security_title'),
            __('marketing.meta.security_description'),
            route('security')
        ));
    }

    public function privacy(): View
    {
        return view('pages.privacy', $this->pageMeta(
            __('marketing.meta.privacy_title'),
            __('marketing.meta.privacy_description'),
            route('privacy')
        ));
    }

    public function terms(): View
    {
        return view('pages.terms', $this->pageMeta(
            __('marketing.meta.terms_title'),
            __('marketing.meta.terms_description'),
            route('terms')
        ));
    }

    public function contact(): View
    {
        return view('pages.contact', [
            ...$this->pageMeta(
                __('marketing.meta.contact_title'),
                __('marketing.meta.contact_description'),
                route('contact')
            ),
            'apps' => $this->products->all(),
            'inquiryType' => 'contact',
            'selectedApp' => request('app'),
            'pageKicker' => __('marketing.contact_page.kicker'),
            'pageTitle' => __('marketing.contact_page.title'),
            'pageLead' => __('marketing.contact_page.lead'),
        ]);
    }

    public function demo(): View
    {
        return view('pages.contact', [
            ...$this->pageMeta(
                __('marketing.meta.demo_title'),
                __('marketing.meta.demo_description'),
                route('demo')
            ),
            'apps' => $this->products->all(),
            'inquiryType' => 'demo',
            'selectedApp' => request('app'),
            'pageKicker' => __('marketing.demo_page.kicker'),
            'pageTitle' => __('marketing.demo_page.title'),
            'pageLead' => __('marketing.demo_page.lead'),
        ]);
    }

    private function localizedServices(): Collection
    {
        $services = collect(config('businessos_services.services', []));
        $locale = app()->getLocale();

        if (! in_array($locale, ['fa', 'ps'], true)) {
            return $services;
        }

        return $services->map(function (array $service) use ($locale): array {
            $key = 'services.catalog.'.($service['slug'] ?? '');

            if (! app('translator')->has($key, $locale)) {
                return $service;
            }

            $translation = trans($key, [], $locale);

            return is_array($translation) ? array_replace_recursive($service, $translation) : $service;
        });
    }

    private function localizedServiceFaqs(): array
    {
        $locale = app()->getLocale();

        if (in_array($locale, ['fa', 'ps'], true) && app('translator')->has('services.faq', $locale)) {
            $faq = trans('services.faq', [], $locale);

            if (is_array($faq)) {
                return $faq;
            }
        }

        return config('businessos_services.faq', []);
    }

    private function latestGuides(): Collection
    {
        try {
            return Guide::published()->latest('published_at')->limit(3)->get();
        } catch (Throwable) {
            return collect();
        }
    }

    private function latestCaseStudies(): Collection
    {
        try {
            return CaseStudy::published()->latest('published_at')->limit(3)->get();
        } catch (Throwable) {
            return collect();
        }
    }

    private function pageMeta(string $title, string $description, string $canonical): array
    {
        return [
            'meta' => [
                'title' => $title,
                'description' => $description,
                'canonical' => $canonical,
                'localized' => true,
            ],
            'schema' => [],
        ];
    }
}
