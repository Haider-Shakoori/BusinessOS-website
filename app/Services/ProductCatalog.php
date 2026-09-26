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
                ->mapWithKeys(fn (Product $product) => [$product->slug => $this->localizeDatabaseProduct($product)]);

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
                ->mapWithKeys(fn (Product $product) => [$product->slug => $this->localizeDatabaseProduct($product)]);

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
                return $this->localizeDatabaseProduct($product);
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

        return $this->applyLanguageOverlay($app);
    }

    private function localizeDatabaseProduct(Product $product): array
    {
        $app = $this->applyLanguageOverlay($product->toMarketingArray());
        $locale = app()->getLocale();

        if (in_array($locale, ['fa', 'ps'], true) === false) {
            return $app;
        }

        $translation = (array) data_get($product->content, 'translations.'.$locale, []);

        foreach (['name', 'eyebrow', 'headline', 'short_description', 'description'] as $key) {
            if (isset($translation[$key]) && is_string($translation[$key]) && trim($translation[$key]) !== '') {
                $app[$key] = $translation[$key];
            }
        }

        if (isset($translation['seo_title']) && is_string($translation['seo_title']) && trim($translation['seo_title']) !== '') {
            $app['seo']['title'] = $translation['seo_title'];
        }

        if (isset($translation['seo_description']) && is_string($translation['seo_description']) && trim($translation['seo_description']) !== '') {
            $app['seo']['description'] = $translation['seo_description'];
        }

        return $app;
    }

    private function applyLanguageOverlay(array $app): array
    {
        $locale = app()->getLocale();

        if (in_array($locale, ['fa', 'ps'], true) === false || empty($app['slug'])) {
            return $app;
        }

        $key = 'products.'.$app['slug'];

        if (app('translator')->has($key, $locale) === false) {
            return $app;
        }

        $overlay = trans($key, [], $locale);

        if (is_array($overlay) === false || $overlay === []) {
            return $app;
        }

        $app = $this->mergeLocalized($app, $overlay);
        $app['has_localized_content'] = true;

        return $app;
    }

    private function mergeLocalized(array $base, array $overlay): array
    {
        foreach ($overlay as $key => $value) {
            if (is_array($value) && isset($base[$key]) && is_array($base[$key]) && array_is_list($value) === false) {
                $base[$key] = $this->mergeLocalized($base[$key], $value);
                continue;
            }

            $base[$key] = $value;
        }

        return $base;
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
