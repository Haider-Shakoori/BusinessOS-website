<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Throwable;

class ProductCatalog
{
    public function all(): Collection
    {
        $configured = $this->configuredProducts();

        try {
            $database = Product::query()
                ->publiclyVisible()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
                ->mapWithKeys(fn (Product $product) => [$product->slug => $product->toMarketingArray()]);

            return $database
                ->union($configured)
                ->sortBy(fn (array $app) => sprintf(
                    '%08d|%s',
                    (int) ($app['sort_order'] ?? 9999),
                    $app['name'] ?? ''
                ))
                ->values();
        } catch (Throwable) {
            return $configured->values();
        }
    }

    public function homepage(): Collection
    {
        $configured = $this->configuredProducts()
            ->filter(fn (array $app) => (bool) ($app['show_on_homepage'] ?? true))
            ->filter(fn (array $app) => (bool) ($app['is_visible'] ?? true))
            ->filter(fn (array $app) => ($app['publication_state'] ?? 'published') === 'published');

        try {
            $database = Product::query()
                ->homepage()
                ->get()
                ->mapWithKeys(fn (Product $product) => [$product->slug => $product->toMarketingArray()]);

            return $database
                ->union($configured)
                ->sortBy(fn (array $app) => sprintf(
                    '%08d|%s',
                    (int) ($app['homepage_order'] ?? $app['sort_order'] ?? 9999),
                    $app['name'] ?? ''
                ))
                ->values();
        } catch (Throwable) {
            return $configured->values();
        }
    }

    public function find(string $slug): ?array
    {
        try {
            $product = Product::query()
                ->publiclyVisible()
                ->where('slug', $slug)
                ->first();

            if ($product) {
                return $product->toMarketingArray();
            }
        } catch (Throwable) {
            // Fall through to the configuration catalog.
        }

        $app = config('businessos.apps.'.$slug);

        return is_array($app) ? $this->localizeConfiguredProduct($app) : null;
    }

    private function localizeConfiguredProduct(array $app): array
    {
        $translations = (array) ($app['translations'] ?? []);
        $hasLocalizedContent = collect(['fa', 'ps'])
            ->every(fn (string $language) => collect((array) ($translations[$language] ?? []))
                ->filter(fn ($item) => is_string($item) && trim($item) !== '')
                ->isNotEmpty());

        $app['has_localized_content'] = $hasLocalizedContent;

        $locale = app()->getLocale();
        if (! in_array($locale, ['fa', 'ps'], true)) {
            return $app;
        }

        $translation = (array) ($translations[$locale] ?? []);
        foreach (['name', 'eyebrow', 'headline', 'short_description', 'description'] as $key) {
            if (isset($translation[$key]) && is_string($translation[$key]) && trim($translation[$key]) !== '') {
                $app[$key] = $translation[$key];
            }
        }

        if (isset($translation['seo_title']) && trim((string) $translation['seo_title']) !== '') {
            $app['seo']['title'] = $translation['seo_title'];
        }
        if (isset($translation['seo_description']) && trim((string) $translation['seo_description']) !== '') {
            $app['seo']['description'] = $translation['seo_description'];
        }

        return $app;
    }

    private function configuredProducts(): Collection
    {
        return collect(config('businessos.apps', []))
            ->values()
            ->map(fn (array $app, int $index) => $this->localizeConfiguredProduct(array_merge([
                'sort_order' => ($index + 1) * 10,
                'homepage_order' => ($index + 1) * 10,
                'show_on_homepage' => true,
                'is_visible' => true,
                'publication_state' => 'published',
            ], $app)))
            ->filter(fn (array $app) => (bool) $app['is_visible'])
            ->filter(fn (array $app) => $app['publication_state'] === 'published')
            ->keyBy('slug');
    }
}
