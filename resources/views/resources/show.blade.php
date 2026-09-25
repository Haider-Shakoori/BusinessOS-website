@extends('layouts.marketing')

@section('content')
<article class="guide-page">
    <header class="guide-header">
        <div class="shell guide-shell">
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>/</span>
                <a href="{{ route('resources.index') }}">Resources</a><span>/</span>
                <strong>{{ $guide->category }}</strong>
            </nav>
            <span class="kicker">{{ $guide->category }}</span>
            <h1>{{ $guide->title }}</h1>
            <p>{{ $guide->excerpt }}</p>
            <div class="guide-meta">
                <span>{{ $guide->author_name ?: 'BusinessOS Editorial Team' }}</span>
                @if($guide->author_role)<span>{{ $guide->author_role }}</span>@endif
                <time datetime="{{ $guide->published_at?->toDateString() }}">{{ $guide->published_at?->format('F j, Y') }}</time>
                @if($guide->updated_at && $guide->published_at && $guide->updated_at->gt($guide->published_at->copy()->addDay()))
                    <span>Updated {{ $guide->updated_at->format('F j, Y') }}</span>
                @endif
            </div>
        </div>
    </header>

    <section class="section guide-body-section">
        <div class="shell guide-shell">
            <div class="guide-body">
                @foreach (preg_split('/\R{2,}/', trim($guide->content)) as $block)
                    @php
                        $block = trim($block);
                        $lines = preg_split('/\R/', $block);
                        $isList = count($lines) > 0 && collect($lines)->every(fn ($line) => str_starts_with(trim($line), '- '));
                    @endphp

                    @if(str_starts_with($block, '### '))
                        <h3>{{ trim(substr($block, 4)) }}</h3>
                    @elseif(str_starts_with($block, '## '))
                        <h2>{{ trim(substr($block, 3)) }}</h2>
                    @elseif($isList)
                        <ul>
                            @foreach($lines as $line)<li>{{ trim(substr(trim($line), 2)) }}</li>@endforeach
                        </ul>
                    @else
                        <p>{{ $block }}</p>
                    @endif
                @endforeach
            </div>
            @if($guide->author_bio)
                <aside class="seo-explainer-card" aria-label="About the author">
                    <div><span class="kicker">About the author</span><h2>{{ $guide->author_name ?: 'BusinessOS Editorial Team' }}</h2></div>
                    <div><p>{{ $guide->author_bio }}</p></div>
                </aside>
            @endif

            @if($relatedPages->count())
                <div class="guide-end">
                    <span class="kicker">Related services</span>
                    <h2>Continue from the guide into implementation.</h2>
                    <div class="use-case-list">
                        @foreach($relatedPages as $page)
                            <div><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><strong><a href="{{ route('seo-pages.show', $page) }}">{{ $page->title }}</a></strong><i>→</i></div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="guide-end">
                <span class="kicker">BusinessOS resources</span>
                <h2>Turn useful ideas into better operations.</h2>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ route('apps.index') }}">Explore apps <span>↗</span></a>
                    <a class="button button-ghost" href="{{ route('resources.index') }}">More guides</a>
                </div>
            </div>
        </div>
    </section>
</article>
@endsection
