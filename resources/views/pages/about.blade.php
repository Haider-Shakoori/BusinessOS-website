@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero">
    <div class="shell narrow-shell">
        <span class="kicker">About BusinessOS</span>
        <h1>Software shaped around the way businesses actually operate.</h1>
        <p>BusinessOS is a growing software ecosystem focused on practical business workflows: sales, field operations, automation, analytics and the work that connects them.</p>
    </div>
</section>

<section class="section trust-content-section">
    <div class="shell trust-content-grid">
        <aside><span class="story-index">01 / APPROACH</span></aside>
        <div class="prose-block">
            <h2>Focused products instead of one overloaded platform.</h2>
            <p>BusinessOS applications are built around clear operational problems. A field-sales product should feel like field-sales software, not a generic enterprise system with hundreds of unrelated menus.</p>
            <p>Each product can stand on its own while sharing a consistent approach to usability, performance, security and long-term maintainability.</p>
        </div>
    </div>
</section>

<section class="section trust-content-section muted-section">
    <div class="shell trust-card-grid">
        <article><span>01</span><h3>Practical first</h3><p>Features must earn their place by solving a real workflow problem.</p></article>
        <article><span>02</span><h3>Fast everywhere</h3><p>Performance is treated as a product requirement, including on constrained mobile networks.</p></article>
        <article><span>03</span><h3>Mobile matters</h3><p>Products used away from a desk are designed with mobile work as a primary surface.</p></article>
        <article><span>04</span><h3>Built to evolve</h3><p>Clean product boundaries make it possible to expand the ecosystem without turning it into a monolith.</p></article>
    </div>
</section>

<section class="section final-cta">
    <div class="shell final-cta-card">
        <div class="cta-orb" aria-hidden="true"></div>
        <span class="kicker">Explore BusinessOS</span>
        <h2>Start with the operational problem you want to improve.</h2>
        <p>See the current applications or tell us what your team needs.</p>
        <div class="hero-actions centered-actions">
            <a class="button button-primary" href="{{ route('apps.index') }}">Explore apps <span>↗</span></a>
            <a class="button button-ghost" href="{{ route('contact') }}">Contact BusinessOS</a>
        </div>
    </div>
</section>
@endsection
