@extends('layouts.marketing')

@section('content')
@php
    $localizedEditorial = in_array(app()->getLocale(), ['fa', 'ps'], true);
    $displayAuthorName = $localizedEditorial ? __('marketing.ui.guide.editorial_team') : ($guide->author_name ?: __('marketing.ui.guide.editorial_team'));
    $displayAuthorRole = $localizedEditorial ? __('marketing.ui.guide.editorial_role') : $guide->author_role;
    $displayAuthorBio = $localizedEditorial ? __('marketing.ui.guide.editorial_bio') : $guide->author_bio;
@endphp
<article class="guide-page">
    <header class="guide-header">
        <div class="shell guide-shell">
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">{{ __('marketing.ui.guide.home') }}</a><span>/</span>
                <a href="{{ route('resources.index') }}">{{ __('marketing.ui.guide.resources') }}</a><span>/</span>
                <strong>{{ $guide->category }}</strong>
            </nav>
            <span class="kicker">{{ $guide->category }}</span>
            <h1>{{ $guide->title }}</h1>
            <p>{{ $guide->excerpt }}</p>
            <div class="guide-meta">
                <span>{{ $guide->author_name ?: __('marketing.ui.guide.editorial_team') }}</span>
                @if($displayAuthorRole)<span>{{ $displayAuthorRole }}</span>@endif
                <time datetime="{{ $guide->published_at?->toDateString() }}">{{ $guide->published_at?->locale(app()->getLocale())->translatedFormat('F j, Y') }}</time>
                @if($guide->updated_at && $guide->published_at && $guide->updated_at->gt($guide->published_at->copy()->addDay()))
                    <span>{{ __('marketing.ui.guide.updated') }} {{ $guide->updated_at->locale(app()->getLocale())->translatedFormat('F j, Y') }}</span>
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
            @if($displayAuthorBio)
                <aside class="seo-explainer-card" aria-label="{{ __('marketing.ui.guide.author') }}">
                    <div><span class="kicker">About the author</span><h2>{{ $displayAuthorName }}</h2></div>
                    <div><p>{{ $displayAuthorBio }}</p></div>
                </aside>
            @endif

            @if($relatedPages->count())
                <div class="guide-end">
                    <span class="kicker">{{ __('marketing.ui.guide.related_services') }}</span>
                    <h2>{{ __('marketing.ui.guide.related_services_title') }}</h2>
                    <div class="use-case-list">
                        @foreach($relatedPages as $page)
                            <div><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><strong><a href="{{ route('seo-pages.show', $page) }}">{{ $page->title }}</a></strong><i>→</i></div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($relatedProducts->count())
                <div class="guide-end">
                    <span class="kicker">{{ __('marketing.ui.guide.related_products') }}</span>
                    <h2>{{ __('marketing.ui.guide.related_products_title') }}</h2>
                    <div class="use-case-list">
                        @foreach($relatedProducts as $app)
                            <div><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><strong><a href="{{ route('apps.show', $app['slug']) }}">{{ $app['name'] }}</a></strong><i>→</i></div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="guide-end">
                <span class="kicker">{{ __('marketing.ui.guide.resources_kicker') }}</span>
                <h2>{{ __('marketing.ui.guide.resources_title') }}</h2>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ route('apps.index') }}">{{ __('marketing.ui.guide.explore_apps') }} <span>↗</span></a>
                    <a class="button button-ghost" href="{{ route('resources.index') }}">{{ __('marketing.ui.guide.more_guides') }}</a>
                </div>
            </div>
        </div>
    </section>
</article>
@endsection
