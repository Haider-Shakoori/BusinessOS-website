@extends('layouts.marketing')

@section('content')
<section class="page-hero resource-hero">
    <div class="shell narrow-shell">
        <span class="kicker">{{ __('marketing.pages.resources.kicker') }}</span>
        <h1>{{ __('marketing.pages.resources.title') }}</h1>
        <p>{{ __('marketing.pages.resources.lead') }}</p>
    </div>
</section>

<section class="section resource-section">
    <div class="shell">
        @if ($guides->count())
            <div class="resource-grid">
                @foreach ($guides as $guide)
                    <article class="resource-card">
                        <div class="resource-card-top">
                            <span>{{ $guide->category }}</span>
                            <time datetime="{{ $guide->published_at?->toDateString() }}">{{ $guide->published_at?->locale(app()->getLocale())->translatedFormat('M j, Y') }}</time>
                        </div>
                        <h2><a href="{{ route('resources.show', $guide) }}">{{ $guide->title }}</a></h2>
                        <p>{{ $guide->excerpt }}</p>
                        <a class="text-link" href="{{ route('resources.show', $guide) }}">{{ __('marketing.pages.resources.read') }} <span>→</span></a>
                    </article>
                @endforeach
            </div>

            @if ($guides->hasPages())
                <nav class="resource-pagination" aria-label="Resources pagination">
                    @if ($guides->onFirstPage())
                        <span aria-disabled="true">← {{ __('marketing.pages.resources.newer') }}</span>
                    @else
                        <a href="{{ $guides->previousPageUrl() }}">← {{ __('marketing.pages.resources.newer') }}</a>
                    @endif

                    <span>{{ __('marketing.pages.resources.page') }} {{ $guides->currentPage() }} {{ __('marketing.pages.resources.of') }} {{ $guides->lastPage() }}</span>

                    @if ($guides->hasMorePages())
                        <a href="{{ $guides->nextPageUrl() }}">{{ __('marketing.pages.resources.older') }} →</a>
                    @else
                        <span aria-disabled="true">{{ __('marketing.pages.resources.older') }} →</span>
                    @endif
                </nav>
            @endif
        @else
            <div class="resource-empty">
                <span class="kicker">{{ __('marketing.pages.resources.soon') }}</span>
                <h2>{{ __('marketing.pages.resources.empty_title') }}</h2>
                <p>{{ __('marketing.pages.resources.empty_copy') }}</p>
            </div>
        @endif
    </div>
</section>
@endsection
