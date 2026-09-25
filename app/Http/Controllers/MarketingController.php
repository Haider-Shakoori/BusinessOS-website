<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\SeoPage;
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
    ) {}

    public function home(): View
    {
        $apps = $this->products->homepage();
        $latestGuides = $this->latestGuides();
        $services = collect(config('businessos_services.services', []));
        $serviceFaqs = config('businessos_services.faq', []);

        return view('home', [
            'apps' => $apps,
            'latestGuides' => $latestGuides,
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
            ],
            'schema' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'Organization',
                    'name' => 'BusinessOS',
                    'url' => route('home'),
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
                'title' => 'BusinessOS Products — ERP, Field Sales, POS, Restaurant, Pharmacy & Manufacturing',
                'description' => 'Explore BusinessOS software for field sales, ERP, retail POS, waiter-based restaurant ordering, pharmacy operations, raw materials, manufacturing and financial management.',
                'canonical' => route('apps.index'),
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

        return view('apps.show', [
            'app' => $app,
            'meta' => [
                'title' => $app['seo']['title'],
                'description' => $app['seo']['description'],
                'canonical' => route('apps.show', $app['slug']),
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
        $services = collect(config('businessos_services.services', []));
        $serviceFaqs = config('businessos_services.faq', []);

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
                'title' => 'Software Development Services — Websites, Custom ERP, MIS, Web Apps & Data Migration | BusinessOS',
                'description' => 'BusinessOS provides website development, custom ERP and MIS, web applications, data migration, application upgrades, APIs, automation, database systems and software support.',
                'canonical' => route('services'),
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
                'BusinessOS Pricing — Product Pricing & Deployment Options',
                'Review the current commercial model and deployment approach for BusinessOS products without placeholder or invented pricing.',
                route('pricing')
            ),
            'apps' => $this->products->all(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            ...$this->pageMeta(
                'About BusinessOS — Business Software & Custom Software Development',
                'Learn how BusinessOS approaches business software, custom development, modernization, performance and practical digital systems.',
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
            'BusinessOS Security — Product Security Principles',
            'Review the security principles BusinessOS applies to application design, access control, data handling and production operations.',
            route('security')
        ));
    }

    public function privacy(): View
    {
        return view('pages.privacy', $this->pageMeta(
            'BusinessOS Privacy Policy',
            'Read how BusinessOS handles information submitted through the public website and product inquiry forms.',
            route('privacy')
        ));
    }

    public function terms(): View
    {
        return view('pages.terms', $this->pageMeta(
            'BusinessOS Terms of Use',
            'Read the terms governing use of the BusinessOS public website and informational product materials.',
            route('terms')
        ));
    }

    public function contact(): View
    {
        return view('pages.contact', [
            ...$this->pageMeta(
                'Contact BusinessOS — Software Development, Products & Partnerships',
                'Contact BusinessOS about website development, custom ERP or MIS, web applications, data migration, upgrades, products, integrations or partnerships.',
                route('contact')
            ),
            'apps' => $this->products->all(),
            'inquiryType' => 'contact',
            'selectedApp' => request('app'),
            'pageKicker' => 'Contact BusinessOS',
            'pageTitle' => 'Tell us what you need to build, modernize or run better.',
            'pageLead' => 'Share the workflow, website, application, data problem or BusinessOS product you want to discuss. Your request is stored securely for follow-up.',
        ]);
    }

    public function demo(): View
    {
        return view('pages.contact', [
            ...$this->pageMeta(
                'Request a BusinessOS Product Demo',
                'Request a demo of a BusinessOS product and tell us about your team and operational needs.',
                route('demo')
            ),
            'apps' => $this->products->all(),
            'inquiryType' => 'demo',
            'selectedApp' => request('app'),
            'pageKicker' => 'Request a demo',
            'pageTitle' => 'See how BusinessOS fits your actual workflow.',
            'pageLead' => 'Tell us about your team and the workflow you want to improve. We will use that context to make the product conversation relevant.',
        ]);
    }

    private function latestGuides(): Collection
    {
        try {
            return Guide::published()->latest('published_at')->limit(3)->get();
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
            ],
            'schema' => [],
        ];
    }
}
