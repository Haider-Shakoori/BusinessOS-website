<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Services\ContentDiscovery;
use Illuminate\Contracts\View\View;

class CaseStudyController extends Controller
{
    public function __construct(
        private readonly ContentDiscovery $contentDiscovery,
    ) {}

    public function index(): View
    {
        return view('case-studies.index', [
            'caseStudies' => CaseStudy::published()->latest('published_at')->paginate(12),
            'meta' => [
                'title' => 'BusinessOS Case Studies — Practical Software Implementation',
                'description' => 'Explore BusinessOS software implementation studies covering ERP, operations, data, manufacturing, field sales and modernization.',
                'canonical' => route('case-studies.index'),
            ],
            'schema' => [[
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'BusinessOS Case Studies',
                'url' => route('case-studies.index'),
            ]],
        ]);
    }

    public function show(CaseStudy $caseStudy): View
    {
        abort_unless($caseStudy->status === 'published' && $caseStudy->published_at?->lte(now()), 404);

        $relatedContent = $this->contentDiscovery->forCaseStudy($caseStudy->slug);

        return view('case-studies.show', [
            'caseStudy' => $caseStudy,
            'relatedProducts' => $relatedContent['products'],
            'relatedServices' => $relatedContent['services'],
            'relatedGuides' => $relatedContent['guides'],
            'meta' => [
                'title' => $caseStudy->meta_title ?: $caseStudy->title.' | BusinessOS',
                'description' => $caseStudy->meta_description ?: $caseStudy->summary,
                'canonical' => route('case-studies.show', $caseStudy),
            ],
            'schema' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'Article',
                    'headline' => $caseStudy->title,
                    'description' => $caseStudy->summary,
                    'datePublished' => $caseStudy->published_at?->toAtomString(),
                    'dateModified' => $caseStudy->updated_at?->toAtomString(),
                    'author' => ['@type' => 'Organization', 'name' => 'BusinessOS'],
                    'publisher' => ['@type' => 'Organization', 'name' => 'BusinessOS', 'url' => route('home')],
                    'mainEntityOfPage' => route('case-studies.show', $caseStudy),
                ],
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Case studies', 'item' => route('case-studies.index')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $caseStudy->title, 'item' => route('case-studies.show', $caseStudy)],
                    ],
                ],
            ],
        ]);
    }
}
