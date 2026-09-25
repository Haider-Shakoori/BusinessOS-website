@extends('layouts.admin')

@section('title', $page->exists ? 'Edit Search Page' : 'New Search Page')
@section('page-heading', $page->exists ? 'Edit Search Page' : 'New Search Page')

@section('content')
<div class="admin-page-head">
    <div><span class="admin-kicker">Organic search</span><h1>{{ $page->exists ? $page->title : 'Create a useful search landing page.' }}</h1><p>Write for a real buyer question or service need. Publishing adds the page to the sitemap.</p></div>
    @if($page->exists && $page->status === 'published')<a class="admin-secondary-button" href="{{ route('seo-pages.show', $page) }}" target="_blank" rel="noopener">View live ↗</a>@endif
</div>
<form class="cms-editor" method="POST" action="{{ $page->exists ? route('admin.seo-pages.update', $page) : route('admin.seo-pages.store') }}">
    @csrf @if($page->exists) @method('PUT') @endif
    <div class="cms-editor-main">
        <section class="admin-panel admin-form">
            <label>Title<input name="title" maxlength="190" value="{{ old('title', $page->title) }}" required></label>
            <div class="admin-form-row">
                <label>Slug <span>leave blank to generate</span><input name="slug" maxlength="190" value="{{ old('slug', $page->slug) }}"></label>
                <label>Eyebrow<input name="eyebrow" maxlength="190" value="{{ old('eyebrow', $page->eyebrow) }}"></label>
            </div>
            <label>Headline<input name="headline" maxlength="500" value="{{ old('headline', $page->headline) }}" required></label>
            <label>Excerpt<textarea name="excerpt" rows="4" required>{{ old('excerpt', $page->excerpt) }}</textarea></label>
            <label>Page content <span>plain text, blank lines create paragraphs</span><textarea class="cms-content-editor" name="content" rows="22" required>{{ old('content', $page->content) }}</textarea></label>
            <label>Target topics/queries <span>one per line</span><textarea name="target_keywords_text" rows="8">{{ old('target_keywords_text', collect($page->target_keywords ?? [])->implode("
")) }}</textarea></label>
            <label>FAQs <span>Question | Answer, one per line</span><textarea name="faq_text" rows="10">{{ old('faq_text', collect($page->faq ?? [])->map(fn($i) => ($i['question'] ?? '').' | '.($i['answer'] ?? ''))->implode("
")) }}</textarea></label>
            <label>Related product slugs <span>one per line</span><textarea name="related_products_text" rows="6">{{ old('related_products_text', collect($page->related_product_slugs ?? [])->implode("
")) }}</textarea></label>
        </section>
        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>SEARCH</span><h2>SEO metadata</h2></div>
            <label>SEO title<input name="meta_title" maxlength="190" value="{{ old('meta_title', $page->meta_title) }}"></label>
            <label>Meta description<textarea name="meta_description" rows="3" maxlength="255">{{ old('meta_description', $page->meta_description) }}</textarea></label>
        </section>
    </div>
    <aside class="cms-editor-side">
        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>PUBLISHING</span><h2>Status</h2></div>
            <label>Status<select name="status"><option value="draft" @selected(old('status', $page->status ?: 'draft') === 'draft')>Draft</option><option value="published" @selected(old('status', $page->status) === 'published')>Published</option></select></label>
            <button class="admin-primary-button" type="submit">{{ $page->exists ? 'Save changes' : 'Create page' }}</button>
        </section>
        @if($page->exists)<section class="admin-panel danger-panel"><span>TRASH</span><button class="danger-button" type="submit" form="delete-search-page">Move to trash</button></section>@endif
    </aside>
</form>
@if($page->exists)<form id="delete-search-page" method="POST" action="{{ route('admin.seo-pages.destroy', $page) }}">@csrf @method('DELETE')</form>@endif
@endsection
