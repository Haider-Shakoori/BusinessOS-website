<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Models\Product;
use App\Services\IndexNowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $search = trim((string) request('q'));
        $state = trim((string) request('state'));

        $products = Product::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('slug', 'like', '%'.$search.'%')
                        ->orWhere('status', 'like', '%'.$search.'%');
                });
            })
            ->when(
                in_array($state, ['draft', 'published', 'archived'], true),
                fn ($query) => $query->where('publication_state', $state)
            )
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'search', 'state'));
    }

    public function create(): View
    {
        $product = new Product;

        return view('admin.products.form', [
            'product' => $product,
            'editor' => $this->editorData($product),
        ]);
    }

    public function store(SaveProductRequest $request, IndexNowService $indexNow): RedirectResponse
    {
        $product = Product::create($this->prepare($request));

        if ($product->publication_state === 'published' && $product->is_visible) {
            $indexNow->submit(route('apps.show', $product->slug));
        }

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Product created.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'editor' => $this->editorData($product),
        ]);
    }

    public function update(SaveProductRequest $request, Product $product, IndexNowService $indexNow): RedirectResponse
    {
        $product->update($this->prepare($request, $product));

        if ($product->publication_state === 'published' && $product->is_visible) {
            $indexNow->submit(route('apps.show', $product->slug));
        }

        return back()->with('status', 'Product updated.');
    }

    public function destroy(Product $product, IndexNowService $indexNow): RedirectResponse
    {
        $url = route('apps.show', $product->slug);
        $product->delete();
        $indexNow->submit($url);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Product moved to trash.');
    }

    private function prepare(SaveProductRequest $request, ?Product $product = null): array
    {
        $data = $request->validated();
        $content = is_array($product?->content) ? $product->content : [];

        $content['highlights'] = $this->lines($data['highlights_text'] ?? null);
        $content['problem'] = [
            'title' => $data['problem_title'] ?? '',
            'body' => $this->lines($data['problem_body_text'] ?? null),
        ];
        $content['features_intro'] = [
            'title' => $data['features_intro_title'] ?? '',
            'description' => $data['features_intro_description'] ?? '',
        ];
        $content['features'] = array_map(
            fn (array $parts) => ['title' => $parts[0], 'description' => $parts[1]],
            $this->structuredLines($data['features_text'] ?? null, 2)
        );
        $content['use_cases_intro'] = [
            'title' => $data['use_cases_intro_title'] ?? '',
            'description' => $data['use_cases_intro_description'] ?? '',
        ];
        $content['use_cases'] = $this->lines($data['use_cases_text'] ?? null);
        $content['preview'] = [
            'section' => $data['preview_section'] ?? 'Product',
            'title' => $data['preview_title'] ?? 'Overview',
            'status' => $data['preview_status'] ?: $data['status'],
            'metrics' => array_map(
                fn (array $parts) => [
                    'label' => $parts[0],
                    'value' => $parts[1],
                    'detail' => $parts[2],
                ],
                $this->structuredLines($data['preview_metrics_text'] ?? null, 3)
            ),
            'rows' => $this->lines($data['preview_rows_text'] ?? null),
        ];
        $content['spotlight'] = [
            'kicker' => $data['spotlight_kicker'] ?? '',
            'title' => $data['spotlight_title'] ?? '',
            'description' => $data['spotlight_description'] ?? '',
            'items' => $this->lines($data['spotlight_items_text'] ?? null),
        ];
        $content['commercial'] = [
            'pricing_status' => $data['pricing_status'] ?: 'Pricing in preparation',
            'pricing_note' => $data['pricing_note'] ?? '',
        ];
        $content['final'] = [
            'title' => $data['final_title'] ?? '',
            'description' => $data['final_description'] ?? '',
        ];
        $content['faq'] = array_map(
            fn (array $parts) => ['question' => $parts[0], 'answer' => $parts[1]],
            $this->structuredLines($data['faq_text'] ?? null, 2)
        );
        $content['live_note'] = $data['live_note'] ?? null;
        $content['translations'] = [
            'fa' => [
                'name' => $data['name_fa'] ?? '',
                'eyebrow' => $data['eyebrow_fa'] ?? '',
                'headline' => $data['headline_fa'] ?? '',
                'short_description' => $data['short_description_fa'] ?? '',
                'description' => $data['description_fa'] ?? '',
                'seo_title' => $data['seo_title_fa'] ?? '',
                'seo_description' => $data['seo_description_fa'] ?? '',
            ],
            'ps' => [
                'name' => $data['name_ps'] ?? '',
                'eyebrow' => $data['eyebrow_ps'] ?? '',
                'headline' => $data['headline_ps'] ?? '',
                'short_description' => $data['short_description_ps'] ?? '',
                'description' => $data['description_ps'] ?? '',
                'seo_title' => $data['seo_title_ps'] ?? '',
                'seo_description' => $data['seo_description_ps'] ?? '',
            ],
        ];
        $content['commercial']['pricing_model'] = $data['pricing_model'] ?? '';
        $content['commercial']['pricing_plans'] = array_map(
            fn (array $parts) => [
                'name' => $parts[0],
                'price' => $parts[1],
                'description' => $parts[2],
            ],
            $this->structuredLines($data['pricing_plans_text'] ?? null, 3)
        );
        $content['commercial']['deployment_options'] = $this->lines($data['deployment_options_text'] ?? null);

        $attributes = Arr::only($data, [
            'name',
            'icon_letter',
            'eyebrow',
            'headline',
            'short_description',
            'description',
            'category',
            'application_category',
            'operating_system',
            'status',
            'accent',
            'sort_order',
            'homepage_order',
            'publication_state',
            'seo_title',
            'seo_description',
        ]);

        $attributes['slug'] = $data['slug'] ?: $this->uniqueSlug($data['name'], $product);
        $attributes['platforms'] = $this->lines($data['platforms_text'] ?? null);
        $attributes['screenshots'] = $this->lines($data['screenshots_text'] ?? null);
        $attributes['featured'] = $request->boolean('featured');
        $attributes['is_visible'] = $request->boolean('is_visible');
        $attributes['show_on_homepage'] = $request->boolean('show_on_homepage');

        $subdomain = Str::lower(trim((string) ($data['subdomain'] ?? '')));
        $webUrl = trim((string) ($data['web_url'] ?? ''));

        if ($webUrl === '' && $subdomain !== '') {
            $webUrl = 'https://'.$subdomain;
        }

        if ($subdomain === '' && $webUrl !== '') {
            $subdomain = (string) parse_url($webUrl, PHP_URL_HOST);
        }

        $attributes['subdomain'] = $subdomain !== '' ? $subdomain : null;
        $attributes['web_url'] = $webUrl !== '' ? $webUrl : null;
        $attributes['content'] = $content;

        if ($attributes['publication_state'] === 'published') {
            $attributes['published_at'] = $product?->published_at ?? now();
        } else {
            $attributes['published_at'] = null;
        }

        return $attributes;
    }

    private function uniqueSlug(string $name, ?Product $product = null): string
    {
        $base = Str::slug($name) ?: 'product';
        $slug = $base;
        $suffix = 2;

        while (
            Product::withTrashed()
                ->where('slug', $slug)
                ->when($product, fn ($query) => $query->whereKeyNot($product->getKey()))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    private function lines(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn ($line) => trim((string) $line))
            ->filter()
            ->values()
            ->all();
    }

    private function structuredLines(?string $value, int $parts): array
    {
        return collect($this->lines($value))
            ->map(function (string $line) use ($parts): array {
                return array_map(
                    'trim',
                    array_pad(explode('|', $line, $parts), $parts, '')
                );
            })
            ->filter(fn (array $row) => $row[0] !== '')
            ->values()
            ->all();
    }

    private function editorData(Product $product): array
    {
        $content = array_merge(
            Product::marketingDefaults(),
            is_array($product->content) ? $product->content : []
        );

        return [
            'name' => $product->name ?? '',
            'slug' => $product->slug ?? '',
            'icon_letter' => $product->icon_letter ?: 'A',
            'eyebrow' => $product->eyebrow ?? '',
            'headline' => $product->headline ?? '',
            'short_description' => $product->short_description ?? '',
            'description' => $product->description ?? '',
            'category' => $product->category ?: 'BusinessApplication',
            'application_category' => $product->application_category ?: 'BusinessApplication',
            'operating_system' => $product->operating_system ?: 'Web',
            'platforms_text' => $this->lineText($product->platforms ?? []),
            'status' => $product->status ?: 'Planned',
            'accent' => $product->accent ?: 'blue',
            'subdomain' => $product->subdomain ?? '',
            'web_url' => $product->web_url ?? '',
            'featured' => $product->exists ? $product->featured : false,
            'is_visible' => $product->exists ? $product->is_visible : true,
            'show_on_homepage' => $product->exists ? $product->show_on_homepage : true,
            'sort_order' => $product->sort_order ?? 100,
            'homepage_order' => $product->homepage_order ?? 100,
            'publication_state' => $product->publication_state ?: 'draft',
            'seo_title' => $product->seo_title ?? '',
            'seo_description' => $product->seo_description ?? '',
            'screenshots_text' => $this->lineText($product->screenshots ?? []),
            'highlights_text' => $this->lineText($content['highlights'] ?? []),
            'problem_title' => data_get($content, 'problem.title', ''),
            'problem_body_text' => $this->lineText(data_get($content, 'problem.body', [])),
            'features_intro_title' => data_get($content, 'features_intro.title', ''),
            'features_intro_description' => data_get($content, 'features_intro.description', ''),
            'features_text' => collect($content['features'] ?? [])
                ->map(fn (array $item) => ($item['title'] ?? '').' | '.($item['description'] ?? ''))
                ->implode("\n"),
            'use_cases_intro_title' => data_get($content, 'use_cases_intro.title', ''),
            'use_cases_intro_description' => data_get($content, 'use_cases_intro.description', ''),
            'use_cases_text' => $this->lineText($content['use_cases'] ?? []),
            'preview_section' => data_get($content, 'preview.section', ''),
            'preview_title' => data_get($content, 'preview.title', ''),
            'preview_status' => data_get($content, 'preview.status', ''),
            'preview_metrics_text' => collect(data_get($content, 'preview.metrics', []))
                ->map(fn (array $item) => ($item['label'] ?? '').' | '.($item['value'] ?? '').' | '.($item['detail'] ?? ''))
                ->implode("\n"),
            'preview_rows_text' => $this->lineText(data_get($content, 'preview.rows', [])),
            'spotlight_kicker' => data_get($content, 'spotlight.kicker', ''),
            'spotlight_title' => data_get($content, 'spotlight.title', ''),
            'spotlight_description' => data_get($content, 'spotlight.description', ''),
            'spotlight_items_text' => $this->lineText(data_get($content, 'spotlight.items', [])),
            'pricing_status' => data_get($content, 'commercial.pricing_status', 'Pricing in preparation'),
            'pricing_note' => data_get($content, 'commercial.pricing_note', ''),
            'final_title' => data_get($content, 'final.title', ''),
            'final_description' => data_get($content, 'final.description', ''),
            'faq_text' => collect($content['faq'] ?? [])
                ->map(fn (array $item) => ($item['question'] ?? '').' | '.($item['answer'] ?? ''))
                ->implode("\n"),
            'live_note' => $content['live_note'] ?? '',
            'name_fa' => data_get($content, 'translations.fa.name', ''),
            'eyebrow_fa' => data_get($content, 'translations.fa.eyebrow', ''),
            'headline_fa' => data_get($content, 'translations.fa.headline', ''),
            'short_description_fa' => data_get($content, 'translations.fa.short_description', ''),
            'description_fa' => data_get($content, 'translations.fa.description', ''),
            'seo_title_fa' => data_get($content, 'translations.fa.seo_title', ''),
            'seo_description_fa' => data_get($content, 'translations.fa.seo_description', ''),
            'name_ps' => data_get($content, 'translations.ps.name', ''),
            'eyebrow_ps' => data_get($content, 'translations.ps.eyebrow', ''),
            'headline_ps' => data_get($content, 'translations.ps.headline', ''),
            'short_description_ps' => data_get($content, 'translations.ps.short_description', ''),
            'description_ps' => data_get($content, 'translations.ps.description', ''),
            'seo_title_ps' => data_get($content, 'translations.ps.seo_title', ''),
            'seo_description_ps' => data_get($content, 'translations.ps.seo_description', ''),
            'pricing_model' => data_get($content, 'commercial.pricing_model', ''),
            'pricing_plans_text' => collect(data_get($content, 'commercial.pricing_plans', []))
                ->map(fn (array $item) => ($item['name'] ?? '').' | '.($item['price'] ?? '').' | '.($item['description'] ?? ''))
                ->implode("\n"),
            'deployment_options_text' => $this->lineText(data_get($content, 'commercial.deployment_options', [])),
        ];
    }

    private function lineText(array $items): string
    {
        return collect($items)->map(fn ($item) => trim((string) $item))->filter()->implode("\n");
    }
}
