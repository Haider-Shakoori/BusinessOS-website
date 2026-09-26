@extends('layouts.marketing')

@section('content')
<section class="page-hero services-page-hero">
    <div class="shell narrow-shell">
        <div class="eyebrow"><span class="pulse-dot"></span> {{ __('marketing.pages.services.eyebrow') }}</div>
        <h1>{{ __('marketing.pages.services.title') }}</h1>
        <p>{{ __('marketing.pages.services.lead') }}</p>
        <div class="hero-actions">
            <a class="button button-primary" href="{{ route('contact') }}">{{ __('marketing.pages.services.discuss') }} <span aria-hidden="true">→</span></a>
            <a class="button button-ghost" href="{{ route('apps.index') }}">{{ __('marketing.pages.services.explore') }}</a>
        </div>
    </div>
</section>

<section class="service-definition-bar" aria-label="BusinessOS software services summary">
    <div class="shell">
        <strong>{{ __('marketing.pages.services.what') }}</strong>
        <p>{{ __('marketing.pages.services.what_copy') }}</p>
    </div>
</section>

<section class="section service-catalog-section">
    <div class="shell">
        <div class="section-heading split-heading">
            <div>
                <span class="kicker">{{ __('marketing.pages.services.core') }}</span>
                <h2>{{ __('marketing.pages.services.core_title') }}</h2>
            </div>
            <p>{{ __('marketing.pages.services.core_copy') }}</p>
        </div>

        <div class="service-catalog-grid">
            @foreach ($services as $service)
                <article id="{{ $service['slug'] }}" class="service-catalog-card">
                    <span class="service-index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $service['name'] }}</h3>
                    <p class="service-short">{{ $service['short'] }}</p>
                    <p>{{ $service['description'] }}</p>
                    <div class="service-topic-row">
                        @foreach ($service['topics'] as $topic)
                            <span>{{ $topic }}</span>
                        @endforeach
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if($searchPages->count())
<section class="section muted-section">
    <div class="shell">
        <div class="section-heading split-heading">
            <div><span class="kicker">{{ __('marketing.pages.services.guides') }}</span><h2>{{ __('marketing.pages.services.guides_title') }}</h2></div>
            <p>{{ __('marketing.pages.services.guides_copy') }}</p>
        </div>
        <div class="resource-grid">
            @foreach($searchPages as $page)
                <article class="resource-card">
                    <div class="resource-card-top"><span>{{ $page->eyebrow ?: 'BusinessOS service' }}</span></div>
                    <h2><a href="{{ route('seo-pages.show', $page) }}">{{ $page->title }}</a></h2>
                    <p>{{ $page->excerpt }}</p>
                    <a class="text-link" href="{{ route('seo-pages.show', $page) }}">{{ __('marketing.pages.services.explore_service') }} <span>→</span></a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section service-process-section">
    <div class="shell two-column">
        <div>
            <span class="kicker">{{ __('marketing.pages.services.approach') }}</span>
            <h2>{{ __('marketing.pages.services.approach_title') }}</h2>
            <p class="section-copy">{{ __('marketing.pages.services.approach_copy') }}</p>
        </div>
        <div class="service-process-list">
            <article><span>01</span><div><strong>{{ __('marketing.ui.services_process.discovery') }}</strong><p>{{ __('marketing.ui.services_process.discovery_copy') }}</p></div></article>
            <article><span>02</span><div><strong>{{ __('marketing.ui.services_process.design') }}</strong><p>{{ __('marketing.ui.services_process.design_copy') }}</p></div></article>
            <article><span>03</span><div><strong>{{ __('marketing.ui.services_process.build') }}</strong><p>{{ __('marketing.ui.services_process.build_copy') }}</p></div></article>
            <article><span>04</span><div><strong>{{ __('marketing.ui.services_process.launch') }}</strong><p>{{ __('marketing.ui.services_process.launch_copy') }}</p></div></article>
            <article><span>05</span><div><strong>{{ __('marketing.ui.services_process.improve') }}</strong><p>{{ __('marketing.ui.services_process.improve_copy') }}</p></div></article>
        </div>
    </div>
</section>

<section class="section seo-explainer-section">
    <div class="shell seo-explainer-card">
        <div>
            <span class="kicker">{{ __('marketing.pages.services.modernize') }}</span>
            <h2>{{ __('marketing.pages.services.modernize_title') }}</h2>
        </div>
        <div>
            <p>{{ __('marketing.pages.services.modernize_copy_1') }}</p>
            <p>{{ __('marketing.pages.services.modernize_copy_2') }}</p>
        </div>
    </div>
</section>

<section class="section faq-section" id="services-faq">
    <div class="shell two-column faq-layout">
        <div>
            <span class="kicker">{{ __('marketing.pages.services.faq') }}</span>
            <h2>{{ __('marketing.pages.services.faq_title') }}</h2>
            <p class="section-copy">{{ __('marketing.pages.services.faq_copy') }}</p>
        </div>
        <div class="faq-list">
            @foreach ($serviceFaqs as $item)
                <details>
                    <summary>{{ $item['question'] }}<span aria-hidden="true">+</span></summary>
                    <p>{{ $item['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<section class="section final-cta">
    <div class="shell final-cta-card">
        <span class="kicker">{{ __('marketing.pages.services.cta_kicker') }}</span>
        <h2>{{ __('marketing.pages.services.cta_title') }}</h2>
        <p>{{ __('marketing.pages.services.cta_copy') }}</p>
        <div class="hero-actions centered-actions">
            <a class="button button-primary" href="{{ route('contact') }}">{{ __('marketing.pages.services.requirements') }} <span aria-hidden="true">→</span></a>
            <a class="button button-ghost" href="{{ route('apps.index') }}">{{ __('marketing.pages.services.view_products') }}</a>
        </div>
    </div>
</section>
@endsection
