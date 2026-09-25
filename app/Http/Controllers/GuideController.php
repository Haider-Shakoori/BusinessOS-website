<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\SeoPage;
use Illuminate\Contracts\View\View;

class GuideController extends Controller
{
    public function index(): View
    {
        $guides = Guide::published()
            ->latest('published_at')
            ->paginate(12);

        return view('resources.index', [
            'guides' => $guides,
            'meta' => [
                'title' => 'BusinessOS Resources — Guides for Better Business Operations',
                'description' => 'Practical BusinessOS guides about field operations, business software, mobile workflows, performance and operational visibility.',
                'canonical' => route('resources.index'),
            ],
            'schema' => [[
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'BusinessOS Resources',
                'url' => route('resources.index'),
            ]],
        ]);
    }

    public function show(Guide $guide): View
    {
        abort_unless(
            $guide->status === 'published'
            && $guide->published_at
            && $guide->published_at->lte(now()),
            404
        );

        $haystack = strtolower($guide->title.' '.$guide->category.' '.$guide->excerpt);
        $relatedPages = SeoPage::published()
            ->get()
            ->map(function (SeoPage $page) use ($haystack): array {
                $score = collect($page->target_keywords ?? [])
                    ->filter(fn (string $keyword) => str_contains($haystack, strtolower($keyword)))
                    ->count();

                if ($score === 0) {
                    $score = str_contains($haystack, strtolower($page->title)) ? 1 : 0;
                }

                return ['page' => $page, 'score' => $score];
            })
            ->filter(fn (array $item) => $item['score'] > 0)
            ->sortByDesc('score')
            ->take(3)
            ->pluck('page');

        return view('resources.show', [
            'guide' => $guide,
            'relatedPages' => $relatedPages,
            'meta' => [
                'title' => $guide->meta_title ?: $guide->title.' — BusinessOS',
                'description' => $guide->meta_description ?: $guide->excerpt,
                'canonical' => route('resources.show', $guide),
            ],
            'schema' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'Article',
                    'headline' => $guide->title,
                    'description' => $guide->excerpt,
                    'datePublished' => $guide->published_at?->toAtomString(),
                    'dateModified' => $guide->updated_at?->toAtomString(),
                    'mainEntityOfPage' => route('resources.show', $guide),
                    'author' => [
                        '@type' => 'Organization',
                        'name' => $guide->author_name ?: 'BusinessOS Editorial Team',
                        'description' => $guide->author_bio,
                    ],
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
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Resources', 'item' => route('resources.index')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $guide->title, 'item' => route('resources.show', $guide)],
                    ],
                ],
            ],
        ]);
    }
}
