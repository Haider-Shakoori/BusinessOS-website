@extends('layouts.admin')

@section('title', $product->exists ? 'Edit Product' : 'New Product')
@section('page-heading', $product->exists ? 'Edit product' : 'New product')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">{{ $product->exists ? 'Editing product' : 'New BusinessOS product' }}</span>
        <h1>{{ $product->exists ? $product->name : 'Create a product without code.' }}</h1>
        <p>Product pages, the app directory, demo selector, homepage product cards and sitemap use this catalog.</p>
    </div>
    @if ($product->exists && $product->publication_state === 'published' && $product->is_visible)
        <a class="admin-secondary-button" href="{{ route('apps.show', $product->slug) }}" target="_blank" rel="noopener">View live ↗</a>
    @endif
</div>

<form class="cms-editor" method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
    @csrf
    @if ($product->exists) @method('PUT') @endif

    <div class="cms-editor-main">
        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>IDENTITY</span><h2>Product positioning</h2></div>

            <div class="admin-form-row">
                <label>Product name
                    <input type="text" name="name" maxlength="190" value="{{ old('name', $editor['name']) }}" required>
                    @error('name')<small>{{ $message }}</small>@enderror
                </label>
                <label>Slug <span>leave blank to generate</span>
                    <input type="text" name="slug" maxlength="190" value="{{ old('slug', $editor['slug']) }}" placeholder="my-product">
                    @error('slug')<small>{{ $message }}</small>@enderror
                </label>
            </div>

            <div class="admin-form-row">
                <label>Icon letter / mark
                    <input type="text" name="icon_letter" maxlength="8" value="{{ old('icon_letter', $editor['icon_letter']) }}" required>
                    @error('icon_letter')<small>{{ $message }}</small>@enderror
                </label>
                <label>Product status <span>customer-facing label</span>
                    <input type="text" name="status" maxlength="80" value="{{ old('status', $editor['status']) }}" placeholder="Live" required>
                    @error('status')<small>{{ $message }}</small>@enderror
                </label>
            </div>

            <label>Eyebrow / category label
                <input type="text" name="eyebrow" maxlength="190" value="{{ old('eyebrow', $editor['eyebrow']) }}" placeholder="Retail & Point of Sale">
                @error('eyebrow')<small>{{ $message }}</small>@enderror
            </label>

            <label>Headline
                <input type="text" name="headline" maxlength="255" value="{{ old('headline', $editor['headline']) }}" required>
                @error('headline')<small>{{ $message }}</small>@enderror
            </label>

            <label>Short description <span>cards and directories</span>
                <textarea name="short_description" rows="4" maxlength="1200" required>{{ old('short_description', $editor['short_description']) }}</textarea>
                @error('short_description')<small>{{ $message }}</small>@enderror
            </label>

            <label>Full description <span>product hero and structured data</span>
                <textarea name="description" rows="6" maxlength="5000" required>{{ old('description', $editor['description']) }}</textarea>
                @error('description')<small>{{ $message }}</small>@enderror
            </label>
        </section>

        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>ACCESS & PLATFORM</span><h2>Domain and compatibility</h2></div>

            <div class="admin-form-row">
                <label>Product subdomain
                    <input type="text" name="subdomain" maxlength="190" value="{{ old('subdomain', $editor['subdomain']) }}" placeholder="product.businessos.af">
                    @error('subdomain')<small>{{ $message }}</small>@enderror
                </label>
                <label>Live URL
                    <input type="url" name="web_url" maxlength="2048" value="{{ old('web_url', $editor['web_url']) }}" placeholder="https://product.businessos.af">
                    @error('web_url')<small>{{ $message }}</small>@enderror
                </label>
            </div>

            <div class="admin-form-row">
                <label>Operating system
                    <input type="text" name="operating_system" maxlength="190" value="{{ old('operating_system', $editor['operating_system']) }}" required>
                    @error('operating_system')<small>{{ $message }}</small>@enderror
                </label>
                <label>Accent token
                    <input type="text" name="accent" maxlength="40" value="{{ old('accent', $editor['accent']) }}" placeholder="blue">
                    @error('accent')<small>{{ $message }}</small>@enderror
                </label>
            </div>

            <label>Platforms <span>one per line</span>
                <textarea name="platforms_text" rows="4">{{ old('platforms_text', $editor['platforms_text']) }}</textarea>
                @error('platforms_text')<small>{{ $message }}</small>@enderror
            </label>

            <div class="admin-form-row">
                <label>Schema category
                    <input type="text" name="category" maxlength="80" value="{{ old('category', $editor['category']) }}" required>
                    @error('category')<small>{{ $message }}</small>@enderror
                </label>
                <label>Application category
                    <input type="text" name="application_category" maxlength="80" value="{{ old('application_category', $editor['application_category']) }}" required>
                    @error('application_category')<small>{{ $message }}</small>@enderror
                </label>
            </div>

            <label>Live note <span>optional deployment/status clarification</span>
                <textarea name="live_note" rows="3">{{ old('live_note', $editor['live_note']) }}</textarea>
                @error('live_note')<small>{{ $message }}</small>@enderror
            </label>
        </section>

        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>PRODUCT STORY</span><h2>Highlights and problem</h2></div>

            <label>Highlights <span>one item per line</span>
                <textarea name="highlights_text" rows="6">{{ old('highlights_text', $editor['highlights_text']) }}</textarea>
                @error('highlights_text')<small>{{ $message }}</small>@enderror
            </label>

            <label>Problem section title
                <input type="text" name="problem_title" maxlength="500" value="{{ old('problem_title', $editor['problem_title']) }}">
                @error('problem_title')<small>{{ $message }}</small>@enderror
            </label>

            <label>Problem section paragraphs <span>one paragraph per line</span>
                <textarea name="problem_body_text" rows="6">{{ old('problem_body_text', $editor['problem_body_text']) }}</textarea>
                @error('problem_body_text')<small>{{ $message }}</small>@enderror
            </label>
        </section>

        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>CAPABILITIES</span><h2>Features and use cases</h2></div>

            <label>Features section title
                <input type="text" name="features_intro_title" maxlength="500" value="{{ old('features_intro_title', $editor['features_intro_title']) }}">
                @error('features_intro_title')<small>{{ $message }}</small>@enderror
            </label>
            <label>Features section description
                <textarea name="features_intro_description" rows="3">{{ old('features_intro_description', $editor['features_intro_description']) }}</textarea>
                @error('features_intro_description')<small>{{ $message }}</small>@enderror
            </label>
            <label>Features <span>one per line: Title | Description</span>
                <textarea name="features_text" rows="10">{{ old('features_text', $editor['features_text']) }}</textarea>
                @error('features_text')<small>{{ $message }}</small>@enderror
            </label>

            <label>Use cases section title
                <input type="text" name="use_cases_intro_title" maxlength="500" value="{{ old('use_cases_intro_title', $editor['use_cases_intro_title']) }}">
                @error('use_cases_intro_title')<small>{{ $message }}</small>@enderror
            </label>
            <label>Use cases section description
                <textarea name="use_cases_intro_description" rows="3">{{ old('use_cases_intro_description', $editor['use_cases_intro_description']) }}</textarea>
                @error('use_cases_intro_description')<small>{{ $message }}</small>@enderror
            </label>
            <label>Use cases <span>one item per line</span>
                <textarea name="use_cases_text" rows="7">{{ old('use_cases_text', $editor['use_cases_text']) }}</textarea>
                @error('use_cases_text')<small>{{ $message }}</small>@enderror
            </label>
        </section>

        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>INTERFACE PREVIEW</span><h2>Preview and screenshots</h2></div>

            <div class="admin-form-row">
                <label>Preview section
                    <input type="text" name="preview_section" maxlength="120" value="{{ old('preview_section', $editor['preview_section']) }}">
                    @error('preview_section')<small>{{ $message }}</small>@enderror
                </label>
                <label>Preview title
                    <input type="text" name="preview_title" maxlength="190" value="{{ old('preview_title', $editor['preview_title']) }}">
                    @error('preview_title')<small>{{ $message }}</small>@enderror
                </label>
            </div>

            <label>Preview status
                <input type="text" name="preview_status" maxlength="80" value="{{ old('preview_status', $editor['preview_status']) }}">
                @error('preview_status')<small>{{ $message }}</small>@enderror
            </label>

            <label>Preview metrics <span>one per line: Label | Value | Detail</span>
                <textarea name="preview_metrics_text" rows="6">{{ old('preview_metrics_text', $editor['preview_metrics_text']) }}</textarea>
                @error('preview_metrics_text')<small>{{ $message }}</small>@enderror
            </label>

            <label>Preview rows <span>one item per line</span>
                <textarea name="preview_rows_text" rows="5">{{ old('preview_rows_text', $editor['preview_rows_text']) }}</textarea>
                @error('preview_rows_text')<small>{{ $message }}</small>@enderror
            </label>

            <label>Screenshot references <span>one URL or public asset path per line; optimized uploads are handled by the upcoming Media CMS</span>
                <textarea name="screenshots_text" rows="5">{{ old('screenshots_text', $editor['screenshots_text']) }}</textarea>
                @error('screenshots_text')<small>{{ $message }}</small>@enderror
            </label>
        </section>

        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>SPOTLIGHT & COMMERCIAL</span><h2>Rollout and pricing text</h2></div>

            <label>Spotlight kicker
                <input type="text" name="spotlight_kicker" maxlength="190" value="{{ old('spotlight_kicker', $editor['spotlight_kicker']) }}">
                @error('spotlight_kicker')<small>{{ $message }}</small>@enderror
            </label>
            <label>Spotlight title
                <input type="text" name="spotlight_title" maxlength="500" value="{{ old('spotlight_title', $editor['spotlight_title']) }}">
                @error('spotlight_title')<small>{{ $message }}</small>@enderror
            </label>
            <label>Spotlight description
                <textarea name="spotlight_description" rows="4">{{ old('spotlight_description', $editor['spotlight_description']) }}</textarea>
                @error('spotlight_description')<small>{{ $message }}</small>@enderror
            </label>
            <label>Spotlight items <span>one item per line</span>
                <textarea name="spotlight_items_text" rows="4">{{ old('spotlight_items_text', $editor['spotlight_items_text']) }}</textarea>
                @error('spotlight_items_text')<small>{{ $message }}</small>@enderror
            </label>

            <div class="admin-form-row">
                <label>Pricing status
                    <input type="text" name="pricing_status" maxlength="190" value="{{ old('pricing_status', $editor['pricing_status']) }}">
                    @error('pricing_status')<small>{{ $message }}</small>@enderror
                </label>
                <label>Final CTA title
                    <input type="text" name="final_title" maxlength="500" value="{{ old('final_title', $editor['final_title']) }}">
                    @error('final_title')<small>{{ $message }}</small>@enderror
                </label>
            </div>

            <label>Pricing / commercial note
                <textarea name="pricing_note" rows="5">{{ old('pricing_note', $editor['pricing_note']) }}</textarea>
                @error('pricing_note')<small>{{ $message }}</small>@enderror
            </label>

            <label>Final CTA description
                <textarea name="final_description" rows="4">{{ old('final_description', $editor['final_description']) }}</textarea>
                @error('final_description')<small>{{ $message }}</small>@enderror
            </label>
        </section>

        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>FAQ</span><h2>Product questions</h2></div>
            <label>FAQ items <span>one per line: Question | Answer</span>
                <textarea name="faq_text" rows="10">{{ old('faq_text', $editor['faq_text']) }}</textarea>
                @error('faq_text')<small>{{ $message }}</small>@enderror
            </label>
        </section>

        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>SEARCH</span><h2>SEO metadata</h2></div>
            <label>SEO title
                <input type="text" name="seo_title" maxlength="190" value="{{ old('seo_title', $editor['seo_title']) }}" placeholder="Defaults to product name">
                @error('seo_title')<small>{{ $message }}</small>@enderror
            </label>
            <label>Meta description
                <textarea name="seo_description" rows="3" maxlength="255" placeholder="Defaults to the short description">{{ old('seo_description', $editor['seo_description']) }}</textarea>
                @error('seo_description')<small>{{ $message }}</small>@enderror
            </label>
        </section>
    </div>

    <aside class="cms-editor-side">
        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>PUBLISHING</span><h2>Visibility</h2></div>

            <label>Publication state
                <select name="publication_state" required>
                    <option value="draft" @selected(old('publication_state', $editor['publication_state']) === 'draft')>Draft</option>
                    <option value="published" @selected(old('publication_state', $editor['publication_state']) === 'published')>Published</option>
                    <option value="archived" @selected(old('publication_state', $editor['publication_state']) === 'archived')>Archived</option>
                </select>
                @error('publication_state')<small>{{ $message }}</small>@enderror
            </label>

            <input type="hidden" name="is_visible" value="0">
            <label class="admin-check"><input type="checkbox" name="is_visible" value="1" @checked((bool) old('is_visible', $editor['is_visible']))> Publicly visible</label>

            <input type="hidden" name="show_on_homepage" value="0">
            <label class="admin-check"><input type="checkbox" name="show_on_homepage" value="1" @checked((bool) old('show_on_homepage', $editor['show_on_homepage']))> Show on homepage</label>

            <input type="hidden" name="featured" value="0">
            <label class="admin-check"><input type="checkbox" name="featured" value="1" @checked((bool) old('featured', $editor['featured']))> Featured product</label>

            <div class="admin-form-row">
                <label>Directory order
                    <input type="number" name="sort_order" min="0" max="100000" value="{{ old('sort_order', $editor['sort_order']) }}" required>
                    @error('sort_order')<small>{{ $message }}</small>@enderror
                </label>
                <label>Homepage order
                    <input type="number" name="homepage_order" min="0" max="100000" value="{{ old('homepage_order', $editor['homepage_order']) }}" required>
                    @error('homepage_order')<small>{{ $message }}</small>@enderror
                </label>
            </div>

            @if ($product->published_at)
                <p class="cms-published-at">Published {{ $product->published_at->format('M j, Y g:i A') }}</p>
            @endif

            <button class="admin-primary-button" type="submit">{{ $product->exists ? 'Save changes' : 'Create product' }} <span>→</span></button>
        </section>

        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>NO-CODE CATALOG</span><h2>What updates automatically</h2></div>
            <p class="cms-published-at">Published products can appear in the homepage catalog, app directory, product pages, demo selector and XML sitemap without a code change.</p>
        </section>

        @if ($product->exists)
            <section class="admin-panel danger-panel">
                <span>TRASH</span>
                <p>Soft-delete this product from the CMS. It will stop appearing on the public website.</p>
                <button class="danger-button" type="submit" form="delete-product-form">Move to trash</button>
            </section>
        @endif
    </aside>
</form>

@if ($product->exists)
<form id="delete-product-form" method="POST" action="{{ route('admin.products.destroy', $product) }}">
    @csrf
    @method('DELETE')
</form>
@endif
@endsection
