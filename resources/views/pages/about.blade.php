@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero">
    <div class="shell narrow-shell">
        <span class="kicker">{{ __('marketing.footer.about') }} BusinessOS</span>
        <h1>{{ $aboutTitle }}</h1>
        <p>{{ $aboutLead }}</p>
    </div>
</section>

<section class="section trust-content-section">
    <div class="shell trust-content-grid">
        <aside><span class="story-index">01 / {{ strtoupper(__('marketing.pages.about.approach')) }}</span></aside>
        <div class="prose-block">
            <h2>{{ __('marketing.pages.about.focus_title') }}</h2>
            <p>{{ $aboutBody }}</p>
            <p>{{ __('marketing.pages.about.focus_body') }}</p>
        </div>
    </div>
</section>

<section class="section trust-content-section muted-section">
    <div class="shell trust-card-grid">
        <article><span>01</span><h3>{{ __('marketing.pages.about.practical') }}</h3><p>{{ __('marketing.pages.about.practical_copy') }}</p></article>
        <article><span>02</span><h3>{{ __('marketing.pages.about.fast') }}</h3><p>{{ __('marketing.pages.about.fast_copy') }}</p></article>
        <article><span>03</span><h3>{{ __('marketing.pages.about.local') }}</h3><p>{{ __('marketing.pages.about.local_copy') }}</p></article>
        <article><span>04</span><h3>{{ __('marketing.pages.about.evolve') }}</h3><p>{{ __('marketing.pages.about.evolve_copy') }}</p></article>
    </div>
</section>

<section class="section final-cta">
    <div class="shell final-cta-card">
        <span class="kicker">{{ __('marketing.pages.about.explore') }}</span>
        <h2>{{ __('marketing.pages.about.cta_title') }}</h2>
        <p>{{ __('marketing.pages.about.cta_copy') }}</p>
        <div class="hero-actions centered-actions">
            <a class="button button-primary" href="{{ route('apps.index') }}">{{ __('marketing.actions.explore_all_apps') }} <span>↗</span></a>
            <a class="button button-ghost" href="{{ route('contact') }}">{{ __('marketing.nav.contact') }}</a>
        </div>
    </div>
</section>
@endsection
