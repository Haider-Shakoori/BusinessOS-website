<?php

namespace App\Http\Controllers;

use App\Models\Guide;
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

        return view('home', [
            'apps' => $apps,
            'latestGuides' => $latestGuides,
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
                'title' => 'BusinessOS Apps — Software for Sales, Operations & Growth',
                'description' => 'Explore BusinessOS applications built for practical business operations, mobile teams, automation and growth.',
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

        return view('apps.show', [
            'app' => $app,
            'meta' => [
                'title' => $app['seo']['title'],
                'description' => $app['seo']['description'],
                'canonical' => route('apps.show', $app['slug']),
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
                'About BusinessOS — Practical Software for Real Business Operations',
                'Learn how BusinessOS approaches product design, performance, mobile work and practical business software.',
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
                'Contact BusinessOS — Product, Sales & Partnership Inquiries',
                'Contact BusinessOS about products, implementation needs, sales questions or partnerships.',
                route('contact')
            ),
            'apps' => $this->products->all(),
            'inquiryType' => 'contact',
            'selectedApp' => request('app'),
            'pageKicker' => 'Contact BusinessOS',
            'pageTitle' => 'Tell us what your business needs to run better.',
            'pageLead' => 'Share the operational problem, team context or BusinessOS product you want to discuss. Your request is stored securely for follow-up.',
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
