<?php

namespace App\Services;

use App\Models\Guide;
use App\Models\SeoPage;
use Illuminate\Support\Collection;
use Throwable;

class ContentDiscovery
{
    public function __construct(private readonly ProductCatalog $products) {}

    public function forProduct(string $slug): array
    {
        $mapping = (array) config('content_discovery.products.'.$slug, []);

        return [
            'services' => $this->publishedServices((array) ($mapping['services'] ?? [])),
            'guides' => $this->publishedGuides((array) ($mapping['guides'] ?? [])),
        ];
    }

    public function forService(string $slug): array
    {
        $mapping = (array) config('content_discovery.services.'.$slug, []);

        return [
            'guides' => $this->publishedGuides((array) ($mapping['guides'] ?? [])),
        ];
    }

    public function forGuide(string $slug): array
    {
        $mapping = (array) config('content_discovery.guides.'.$slug, []);

        return [
            'products' => collect((array) ($mapping['products'] ?? []))
                ->map(fn (string $productSlug) => $this->products->find($productSlug))
                ->filter()
                ->values(),
        ];
    }

    private function publishedServices(array $slugs): Collection
    {
        if ($slugs === []) {
            return collect();
        }

        try {
            $pages = SeoPage::published()->whereIn('slug', $slugs)->get()->keyBy('slug');

            return collect($slugs)->map(fn (string $slug) => $pages->get($slug))->filter()->values();
        } catch (Throwable) {
            return collect();
        }
    }

    private function publishedGuides(array $slugs): Collection
    {
        if ($slugs === []) {
            return collect();
        }

        try {
            $guides = Guide::published()->whereIn('slug', $slugs)->get()->keyBy('slug');

            return collect($slugs)->map(fn (string $slug) => $guides->get($slug))->filter()->values();
        } catch (Throwable) {
            return collect();
        }
    }
}
