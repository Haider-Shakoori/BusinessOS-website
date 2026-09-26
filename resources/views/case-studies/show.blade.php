@extends('layouts.marketing')

@section('content')
<article class="guide-page">
    <header class="guide-header">
        <div class="shell guide-shell">
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">{{ __('marketing.ui.case_studies.home') }}</a><span>/</span>
                <a href="{{ route('case-studies.index') }}">{{ __('marketing.ui.case_studies.title') }}</a><span>/</span>
                <strong>{{ $caseStudy->industry }}</strong>
            </nav>
            <span class="kicker">{{ $caseStudy->industry }}</span>
            <h1>{{ $caseStudy->title }}</h1>
            <p>{{ $caseStudy->summary }}</p>
            <div class="guide-meta">
                <span>BusinessOS</span>
                <time datetime="{{ $caseStudy->published_at?->toDateString() }}">{{ $caseStudy->published_at?->format('F j, Y') }}</time>
            </div>
        </div>
    </header>

    <section class="section guide-body-section">
        <div class="shell guide-shell">
            <div class="guide-body">
                <h2>{{ __('marketing.ui.case_studies.challenge') }}</h2>
                @foreach(preg_split('/\R{2,}/', trim($caseStudy->challenge)) as $paragraph)<p>{{ $paragraph }}</p>@endforeach
                <h2>{{ __('marketing.ui.case_studies.solution') }}</h2>
                @foreach(preg_split('/\R{2,}/', trim($caseStudy->solution)) as $paragraph)<p>{{ $paragraph }}</p>@endforeach
                @if($caseStudy->outcome)
                    <h2>{{ __('marketing.ui.case_studies.outcome') }}</h2>
                    @foreach(preg_split('/\R{2,}/', trim($caseStudy->outcome)) as $paragraph)<p>{{ $paragraph }}</p>@endforeach
                @endif
            </div>
            @if($relatedProducts->count() || $relatedServices->count() || $relatedGuides->count())
                <div class="guide-end">
                    <span class="kicker">{{ __('marketing.ui.case_studies.related') }}</span>
                    <h2>{{ __('marketing.ui.case_studies.related_title') }}</h2>

                    @if($relatedProducts->count())
                        <div class="use-case-list">
                            @foreach($relatedProducts as $app)
                                <div><span>P{{ $loop->iteration }}</span><strong><a href="{{ route('apps.show', $app['slug']) }}">{{ $app['name'] }}</a></strong><i>→</i></div>
                            @endforeach
                        </div>
                    @endif

                    @if($relatedServices->count())
                        <div class="use-case-list">
                            @foreach($relatedServices as $page)
                                <div><span>S{{ $loop->iteration }}</span><strong><a href="{{ route('seo-pages.show', $page) }}">{{ $page->title }}</a></strong><i>→</i></div>
                            @endforeach
                        </div>
                    @endif

                    @if($relatedGuides->count())
                        <div class="use-case-list">
                            @foreach($relatedGuides as $guide)
                                <div><span>G{{ $loop->iteration }}</span><strong><a href="{{ route('resources.show', $guide) }}">{{ $guide->title }}</a></strong><i>→</i></div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            <div class="guide-end">
                <span class="kicker">{{ __('marketing.ui.case_studies.implementation') }}</span>
                <h2>{{ __('marketing.ui.case_studies.similar_title') }}</h2>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ route('contact') }}">{{ __('marketing.ui.case_studies.discuss') }} <span>→</span></a>
                    <a class="button button-ghost" href="{{ route('case-studies.index') }}">{{ __('marketing.ui.case_studies.more') }}</a>
                </div>
            </div>
        </div>
    </section>
</article>
@endsection
