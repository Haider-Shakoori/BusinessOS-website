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
        <aside><span class="story-index">01 / APPROACH</span></aside>
        <div class="prose-block">
            <h2>Focused products and custom solutions instead of one rigid template.</h2>
            <p>{{ $aboutBody }}</p>
            <p>FieldPulse, ERP, POS and specialized industry systems can stand on their own, while custom websites, ERP/MIS projects, migrations and modernization work follow the same BusinessOS approach to usability, performance, security and long-term maintainability.</p>
        </div>
    </div>
</section>

<section class="section trust-content-section muted-section">
    <div class="shell trust-card-grid">
        <article><span>01</span><h3>Practical first</h3><p>Features must earn their place by solving a real workflow problem.</p></article>
        <article><span>02</span><h3>Fast everywhere</h3><p>Performance is treated as a product requirement, including on constrained mobile networks.</p></article>
        <article><span>03</span><h3>Local realities</h3><p>Afghanistan-specific language, currency, connectivity and operating requirements are considered where they matter.</p></article>
        <article><span>04</span><h3>Built to evolve</h3><p>Clear product boundaries make it possible to expand the ecosystem without turning it into a monolith.</p></article>
    </div>
</section>

<section class="section final-cta">
    <div class="shell final-cta-card">
        <span class="kicker">Explore BusinessOS</span>
        <h2>Start with the operational problem you want to improve.</h2>
        <p>See the current applications or tell us what your team needs.</p>
        <div class="hero-actions centered-actions">
            <a class="button button-primary" href="{{ route('apps.index') }}">{{ __('marketing.actions.explore_all_apps') }} <span>↗</span></a>
            <a class="button button-ghost" href="{{ route('contact') }}">{{ __('marketing.nav.contact') }}</a>
        </div>
    </div>
</section>
@endsection
