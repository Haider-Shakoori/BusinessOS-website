<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Throwable;

class ProductCatalog
{
    public function all(): Collection
    {
        try {
            return Product::query()
                ->publiclyVisible()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
                ->map(fn (Product $product) => $product->toMarketingArray());
        } catch (Throwable) {
            return collect(config('businessos.apps', []))->values();
        }
    }

    public function homepage(): Collection
    {
        try {
            return Product::query()
                ->homepage()
                ->get()
                ->map(fn (Product $product) => $product->toMarketingArray());
        } catch (Throwable) {
            return collect(config('businessos.apps', []))->values();
        }
    }

    public function find(string $slug): ?array
    {
        try {
            $product = Product::query()
                ->publiclyVisible()
                ->where('slug', $slug)
                ->first();

            return $product?->toMarketingArray();
        } catch (Throwable) {
            $app = config('businessos.apps.'.$slug);

            return is_array($app) ? $app : null;
        }
    }
}
