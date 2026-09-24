@extends('layouts.marketing')

@section('content')
<section class="page-hero resource-hero">
    <div class="shell narrow-shell">
        <span class="kicker">Guides & resources</span>
        <h1>Practical ideas for running better business operations.</h1>
        <p>BusinessOS resources focus on field work, software decisions, mobile operations and the systems behind clear day-to-day execution.</p>
    </div>
</section>

<section class="section resource-section">
    <div class="shell">
        @if ($guides->count())
            <div class="resource-grid">
                @foreach ($guides as $guide)
                    <article class="resource-card spatial-card" data-tilt data-tilt-strength=".35">
                        <div class="resource-card-top">
                            <span>{{ $guide->category }}</span>
                            <time datetime="{{ $guide->published_at?->toDateString() }}">{{ $guide->published_at?->format('M j, Y') }}</time>
                        </div>
                        <h2><a href="{{ route('resources.show', $guide) }}">{{ $guide->title }}</a></h2>
                        <p>{{ $guide->excerpt }}</p>
                        <a class="text-link" href="{{ route('resources.show', $guide) }}">Read guide <span>→</span></a>
                    </article>
                @endforeach
            </div>

            @if ($guides->hasPages())
                <nav class="resource-pagination" aria-label="Resources pagination">
                    @if ($guides->onFirstPage())
                        <span aria-disabled="true">← Newer</span>
                    @else
                        <a href="{{ $guides->previousPageUrl() }}">← Newer</a>
                    @endif

                    <span>Page {{ $guides->currentPage() }} of {{ $guides->lastPage() }}</span>

                    @if ($guides->hasMorePages())
                        <a href="{{ $guides->nextPageUrl() }}">Older →</a>
                    @else
                        <span aria-disabled="true">Older →</span>
                    @endif
                </nav>
            @endif
        @else
            <div class="resource-empty">
                <span class="kicker">Publishing soon</span>
                <h2>BusinessOS guides are being prepared.</h2>
                <p>The CMS is ready for focused resources without filling the site with thin placeholder content.</p>
            </div>
        @endif
    </div>
</section>
@endsection
