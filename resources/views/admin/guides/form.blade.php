@extends('layouts.admin')

@section('title', $guide->exists ? 'Edit Guide' : 'New Guide')
@section('page-heading', $guide->exists ? 'Edit guide' : 'New guide')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">{{ $guide->exists ? 'Editing resource' : 'New resource' }}</span>
        <h1>{{ $guide->exists ? $guide->title : 'Create a focused guide.' }}</h1>
        <p>Drafts stay private. Publishing makes the guide available on the public resources page and sitemap.</p>
    </div>
    @if ($guide->exists && $guide->status === 'published')
        <a class="admin-secondary-button" href="{{ route('resources.show', $guide) }}" target="_blank" rel="noopener">View live ↗</a>
    @endif
</div>

<form class="cms-editor" method="POST" action="{{ $guide->exists ? route('admin.guides.update', $guide) : route('admin.guides.store') }}">
    @csrf
    @if ($guide->exists) @method('PUT') @endif

    <div class="cms-editor-main">
        <section class="admin-panel admin-form">
            <label>Title
                <input type="text" name="title" maxlength="190" value="{{ old('title', $guide->title) }}" required>
                @error('title')<small>{{ $message }}</small>@enderror
            </label>

            <div class="admin-form-row">
                <label>Slug <span>leave blank to generate</span>
                    <input type="text" name="slug" maxlength="190" value="{{ old('slug', $guide->slug) }}" placeholder="field-sales-guide">
                    @error('slug')<small>{{ $message }}</small>@enderror
                </label>
                <label>Category
                    <input type="text" name="category" maxlength="80" value="{{ old('category', $guide->category ?: 'Guide') }}" required>
                    @error('category')<small>{{ $message }}</small>@enderror
                </label>
            </div>

            <label>Excerpt
                <textarea name="excerpt" rows="4" maxlength="600" required>{{ old('excerpt', $guide->excerpt) }}</textarea>
                @error('excerpt')<small>{{ $message }}</small>@enderror
            </label>

            <label>Guide content <span>plain text, paragraphs preserved</span>
                <textarea class="cms-content-editor" name="content" rows="22" required>{{ old('content', $guide->content) }}</textarea>
                @error('content')<small>{{ $message }}</small>@enderror
            </label>
        </section>

        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>SEARCH</span><h2>SEO metadata</h2></div>
            <label>SEO title
                <input type="text" name="meta_title" maxlength="190" value="{{ old('meta_title', $guide->meta_title) }}" placeholder="Optional — defaults to guide title">
                @error('meta_title')<small>{{ $message }}</small>@enderror
            </label>
            <label>Meta description
                <textarea name="meta_description" rows="3" maxlength="255" placeholder="Optional — defaults to excerpt">{{ old('meta_description', $guide->meta_description) }}</textarea>
                @error('meta_description')<small>{{ $message }}</small>@enderror
            </label>
        </section>
    </div>

    <aside class="cms-editor-side">
        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>PUBLISHING</span><h2>Status</h2></div>
            <label>Status
                <select name="status" required>
                    <option value="draft" @selected(old('status', $guide->status ?: 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status', $guide->status) === 'published')>Published</option>
                </select>
            </label>
            @if ($guide->published_at)
                <p class="cms-published-at">Published {{ $guide->published_at->format('M j, Y g:i A') }}</p>
            @endif
            <button class="admin-primary-button" type="submit">{{ $guide->exists ? 'Save changes' : 'Create guide' }} <span>→</span></button>
        </section>

        @if ($guide->exists)
            <section class="admin-panel danger-panel">
                <span>TRASH</span>
                <p>Remove this guide from the CMS and public website. The database record is soft-deleted.</p>
                <button class="danger-button" type="submit" form="delete-guide-form">Move to trash</button>
            </section>
        @endif
    </aside>
</form>

@if ($guide->exists)
<form id="delete-guide-form" method="POST" action="{{ route('admin.guides.destroy', $guide) }}">
    @csrf
    @method('DELETE')
</form>
@endif
@endsection
