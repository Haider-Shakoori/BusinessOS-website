<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $position = 0;

        foreach (config('businessos.apps', []) as $app) {
            $position++;

            $webUrl = $app['web_url'] ?? null;

            Product::firstOrCreate(
                ['slug' => $app['slug']],
                [
                    'name' => $app['name'],
                    'icon_letter' => $app['icon_letter'] ?? str($app['name'])->substr(0, 1)->upper()->toString(),
                    'eyebrow' => $app['eyebrow'] ?? null,
                    'headline' => $app['headline'] ?? null,
                    'short_description' => $app['short_description'] ?? null,
                    'description' => $app['description'] ?? null,
                    'category' => $app['category'] ?? 'BusinessApplication',
                    'application_category' => $app['application_category'] ?? 'BusinessApplication',
                    'operating_system' => $app['operating_system'] ?? 'Web',
                    'platforms' => $app['platforms'] ?? [],
                    'status' => $app['status'] ?? null,
                    'accent' => $app['accent'] ?? 'blue',
                    'subdomain' => $webUrl ? parse_url($webUrl, PHP_URL_HOST) : null,
                    'web_url' => $webUrl,
                    'featured' => (bool) ($app['featured'] ?? false),
                    'is_visible' => (bool) ($app['is_visible'] ?? true),
                    'show_on_homepage' => (bool) ($app['show_on_homepage'] ?? true),
                    'sort_order' => (int) ($app['sort_order'] ?? $position * 10),
                    'homepage_order' => (int) ($app['homepage_order'] ?? $position * 10),
                    'publication_state' => $app['publication_state'] ?? 'published',
                    'published_at' => now(),
                    'seo_title' => $app['seo']['title'] ?? null,
                    'seo_description' => $app['seo']['description'] ?? null,
                    'screenshots' => $app['screenshots'] ?? [],
                    'content' => $app,
                ]
            );
        }
    }
}
