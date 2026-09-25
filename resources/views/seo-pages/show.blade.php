@extends('layouts.marketing')

@section('content')
<section class="page-hero">
    <div class="shell narrow-shell">
        <nav class="breadcrumbs" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a><span>/</span>
            <a href="{{ route('services') }}">Services</a><span>/</span>
            <strong>{{ $seoPage->title }}</strong>
        </nav>
        <span class="kicker">{{ $seoPage->eyebrow ?: 'BusinessOS service' }}</span>
        <h1>{{ $seoPage->headline }}</h1>
        <p>{{ $seoPage->excerpt }}</p>
        <div class="hero-actions">
            <a class="button button-primary" href="{{ route('contact') }}">Discuss your requirements <span>→</span></a>
            <a class="button button-ghost" href="{{ route('services') }}">All services</a>
        </div>
    </div>
</section>

<section class="section trust-content-section">
    <div class="shell two-column">
        <div>
            <span class="kicker">What this service covers</span>
            <h2>{{ $seoPage->title }}</h2>
            @if(!empty($seoPage->target_keywords))
                <div class="service-topic-row">
                    @foreach($seoPage->target_keywords as $keyword)<span>{{ $keyword }}</span>@endforeach
                </div>
            @endif
        </div>
        <div class="body-copy">
            @foreach(preg_split('/\R{2,}/', trim($seoPage->content)) as $block)
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
    </div>
</section>

@if($relatedProducts->count())
<section class="section muted-section">
    <div class="shell">
        <div class="section-heading split-heading">
            <div><span class="kicker">Related BusinessOS products</span><h2>Products that can support this workflow.</h2></div>
            <p>These products are relevant where the requirement extends beyond a one-off development project into ongoing business operations.</p>
        </div>
        <div class="directory-grid">
            @foreach($relatedProducts as $app)
                <article class="directory-card">
                    <div class="directory-card-top">
                        <div class="app-letter-icon" aria-hidden="true">{{ $app['icon_letter'] }}</div>
                        <span class="status-pill">{{ $app['status'] }}</span>
                    </div>
                    <span class="kicker">{{ $app['eyebrow'] }}</span>
                    <h2>{{ $app['name'] }}</h2>
                    <p>{{ $app['short_description'] }}</p>
                    <a class="text-link" href="{{ route('apps.show', $app['slug']) }}">Explore {{ $app['name'] }} <span>→</span></a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($relatedGuides->count())
<section class="section">
    <div class="shell">
        <div class="section-heading split-heading">
            <div><span class="kicker">Practical reading</span><h2>Guides related to this service.</h2></div>
            <p>Use these guides to compare options, prepare data and understand the operational choices behind implementation.</p>
        </div>
        <div class="resource-grid">
            @foreach($relatedGuides as $guide)
                <article class="resource-card">
                    <div class="resource-card-top"><span>{{ $guide->category }}</span></div>
                    <h3><a href="{{ route('resources.show', $guide) }}">{{ $guide->title }}</a></h3>
                    <p>{{ $guide->excerpt }}</p>
                    <a class="text-link" href="{{ route('resources.show', $guide) }}">Read guide <span>→</span></a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(!empty($seoPage->faq))
<section class="section faq-section">
    <div class="shell two-column faq-layout">
        <div>
            <span class="kicker">Questions</span>
            <h2>Common questions about {{ strtolower($seoPage->title) }}.</h2>
        </div>
        <div class="faq-list">
            @foreach($seoPage->faq as $item)
                <details>
                    <summary>{{ $item['question'] }}<span aria-hidden="true">+</span></summary>
                    <p>{{ $item['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section final-cta">
    <div class="shell final-cta-card">
        <span class="kicker">BusinessOS</span>
        <h2>Start with the workflow, not a generic software package.</h2>
        <p>Tell us what is not working today, what data you already have and what outcome the business needs.</p>
        <div class="hero-actions centered-actions">
            <a class="button button-primary" href="{{ route('contact') }}">Discuss the project <span>→</span></a>
            <a class="button button-ghost" href="{{ route('resources.index') }}">Read guides</a>
        </div>
    </div>
</section>
@endsection
