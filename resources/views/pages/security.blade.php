@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero">
    <div class="shell narrow-shell">
        <span class="kicker">Security</span>
        <h1>Security is part of the product architecture, not a badge added later.</h1>
        <p>BusinessOS products are designed around controlled access, defensible data handling and production practices appropriate to each application.</p>
    </div>
</section>

<section class="section trust-content-section">
    <div class="shell trust-card-grid security-grid">
        <article><span>01</span><h3>Access control</h3><p>Authentication, authorization and tenant or role boundaries are designed around the permissions each product actually needs.</p></article>
        <article><span>02</span><h3>Data minimization</h3><p>Products should collect and retain operational data for a defined purpose rather than gathering information simply because it is available.</p></article>
        <article><span>03</span><h3>Secure development</h3><p>Automated tests, dependency review, code review and production configuration checks are part of the engineering workflow.</p></article>
        <article><span>04</span><h3>Operational safeguards</h3><p>Backups, secrets management, HTTPS, logging and deployment controls are treated as production requirements and verified per environment.</p></article>
    </div>
</section>

<section class="section trust-content-section muted-section">
    <div class="shell trust-content-grid">
        <aside><span class="story-index">PRODUCT-SPECIFIC</span></aside>
        <div class="prose-block">
            <h2>Security claims stay specific and verifiable.</h2>
            <p>Different BusinessOS products handle different kinds of operational data. Product pages and deployment documentation should describe the controls that are actually implemented for that product rather than implying certifications or guarantees that have not been independently verified.</p>
            <p>If your organization has a security questionnaire, deployment requirement or integration concern, contact us with the context and product involved.</p>
            <a class="text-link" href="{{ route('contact') }}">Contact BusinessOS <span>→</span></a>
        </div>
    </div>
</section>
@endsection
