<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class MarketingController extends Controller
{
    public function home(): View
    {
        $apps = collect(config('businessos.apps'));
        $featured = $apps->firstWhere('featured', true) ?? $apps->first();

        return view('home', [
            'apps' => $apps,
            'featured' => $featured,
            'meta' => [
                'title' => 'BusinessOS — Fast Business Software for Real Operations',
                'description' => 'Discover BusinessOS applications for sales, operations, automation and growth, engineered for modern teams and low-bandwidth environments.',
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
        $apps = collect(config('businessos.apps'));

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
        $app = config("businessos.apps.{$slug}");

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
        return view('pages.pricing', $this->pageMeta(
            'BusinessOS Pricing — Flexible Plans for Business Software',
            'Explore the BusinessOS pricing approach. Product pricing is configured around the application, team size and deployment needs without invented public price claims.',
            route('pricing')
        ));
    }

    public function about(): View
    {
        return view('pages.about', $this->pageMeta(
            'About BusinessOS — Practical Software for Real Business Operations',
            'Learn how BusinessOS approaches product design, performance, mobile work and practical business software.',
            route('about')
        ));
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
                'Request a demo of FieldPulse or another BusinessOS product and tell us about your team and operational needs.',
                route('demo')
            ),
            'inquiryType' => 'demo',
            'selectedApp' => request('app', 'fieldpulse'),
            'pageKicker' => 'Request a demo',
            'pageTitle' => 'See how BusinessOS fits your actual workflow.',
            'pageLead' => 'Tell us about your team and the workflow you want to improve. We will use that context to make the product conversation relevant.',
        ]);
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
