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
                ->sortBy(fn (array $app) => [
                    $app['sort_order'] ?? 9999,
                    $app['name'] ?? '',
                ])
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
                ->sortBy(fn (array $app) => [
                    $app['homepage_order'] ?? $app['sort_order'] ?? 9999,
                    $app['name'] ?? '',
                ])
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

        return is_array($app) ? $app : null;
    }

    private function configuredProducts(): Collection
    {
        return collect(config('businessos.apps', []))
            ->filter(fn (array $app) => (bool) ($app['is_visible'] ?? true))
            ->filter(fn (array $app) => ($app['publication_state'] ?? 'published') === 'published')
            ->values()
            ->keyBy('slug');
    }
}
