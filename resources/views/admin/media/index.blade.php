@extends('layouts.admin')

@section('title', 'Media')
@section('page-heading', 'Media')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">Media library</span>
        <h1>Product screenshots and website images.</h1>
        <p>Upload source images once. The server creates WebP and AVIF variants when its image library supports those formats.</p>
    </div>
</div>

<section class="admin-panel admin-form">
    <div class="admin-form-section-head"><span>UPLOAD</span><h2>Add image</h2></div>
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="admin-form-row">
            <label>Image
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/avif" required>
                @error('image')<small>{{ $message }}</small>@enderror
            </label>
            <label>Alt text
                <input type="text" name="alt_text" maxlength="255" placeholder="Describe the useful visual content">
            </label>
        </div>
        <label>Caption <span>optional</span>
            <textarea name="caption" rows="2" maxlength="2000"></textarea>
        </label>
        <button class="admin-primary-button" type="submit">Upload image</button>
    </form>
</section>

<div class="media-grid">
    @forelse ($assets as $asset)
        <article class="admin-panel media-card">
            <picture>
                @if($asset->avif_path)<source srcset="{{ $asset->url('avif') }}" type="image/avif">@endif
                @if($asset->webp_path)<source srcset="{{ $asset->url('webp') }}" type="image/webp">@endif
                <img src="{{ $asset->url() }}" alt="{{ $asset->alt_text ?: '' }}" @if($asset->width) width="{{ $asset->width }}" @endif @if($asset->height) height="{{ $asset->height }}" @endif loading="lazy" decoding="async">
            </picture>
            <div>
                <strong>{{ $asset->original_name }}</strong>
                <small>{{ $asset->width }}×{{ $asset->height }} · {{ number_format($asset->size_bytes / 1024, 1) }} KB</small>
                <form method="POST" action="{{ route('admin.media.update', $asset) }}" class="admin-form">
                    @csrf
                    @method('PUT')
                    <label>Alt text
                        <input type="text" name="alt_text" maxlength="255" value="{{ $asset->alt_text }}" placeholder="Describe what is visible and useful in the image">
                    </label>
                    <label>Caption
                        <textarea name="caption" rows="2" maxlength="2000">{{ $asset->caption }}</textarea>
                    </label>
                    <button class="admin-secondary-button" type="submit">Save image metadata</button>
                </form>
                <label>Preferred URL
                    <input type="text" readonly value="{{ $asset->avif_path ? $asset->url('avif') : ($asset->webp_path ? $asset->url('webp') : $asset->url()) }}">
                </label>
                <label>Product screenshot reference
                    <input type="text" readonly value="{{ ($asset->avif_path ? $asset->url('avif') : ($asset->webp_path ? $asset->url('webp') : $asset->url())).' | '.($asset->alt_text ?? '').' | '.($asset->caption ?? '') }}">
                </label>
                <div class="media-format-row">
                    @if($asset->webp_path)<a href="{{ $asset->url('webp') }}" target="_blank" rel="noopener">WebP ↗</a>@endif
                    @if($asset->avif_path)<a href="{{ $asset->url('avif') }}" target="_blank" rel="noopener">AVIF ↗</a>@endif
                    <a href="{{ $asset->url() }}" target="_blank" rel="noopener">Original ↗</a>
                </div>
                <form method="POST" action="{{ route('admin.media.destroy', $asset) }}" onsubmit="return confirm('Delete this media asset?')">
                    @csrf
                    @method('DELETE')
                    <button class="admin-danger-button" type="submit">Delete</button>
                </form>
            </div>
        </article>
    @empty
        <div class="admin-panel cms-empty">No media uploaded yet.</div>
    @endforelse
</div>

@if ($assets->hasPages())
    <div class="admin-pagination">
        @if (!$assets->onFirstPage())<a href="{{ $assets->previousPageUrl() }}">← Previous</a>@else<span>← Previous</span>@endif
        <span>Page {{ $assets->currentPage() }} of {{ $assets->lastPage() }}</span>
        @if ($assets->hasMorePages())<a href="{{ $assets->nextPageUrl() }}">Next →</a>@else<span>Next →</span>@endif
    </div>
@endif
@endsection
