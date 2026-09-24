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
            ],
        ]);
    }
}
