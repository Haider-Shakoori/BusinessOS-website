@extends('layouts.marketing')

@section('content')
<section class="page-hero services-page-hero">
    <div class="shell narrow-shell">
        <div class="eyebrow"><span class="pulse-dot"></span> Software development & technology solutions</div>
        <h1>Custom software for the workflow your business actually needs.</h1>
        <p>BusinessOS builds websites, custom ERP and MIS platforms, web applications, database systems and integrations. We also migrate business data, modernize older applications and support the software after launch.</p>
        <div class="hero-actions">
            <a class="button button-primary" href="{{ route('contact') }}">Discuss your project <span aria-hidden="true">→</span></a>
            <a class="button button-ghost" href="{{ route('apps.index') }}">Explore BusinessOS products</a>
        </div>
    </div>
</section>

<section class="service-definition-bar" aria-label="BusinessOS software services summary">
    <div class="shell">
        <strong>What we do</strong>
        <p>End-to-end software development, modernization, data migration, integration and operational systems for businesses that need technology matched to real processes.</p>
    </div>
</section>

<section class="section service-catalog-section">
    <div class="shell">
        <div class="section-heading split-heading">
            <div>
                <span class="kicker">Core services</span>
                <h2>From a focused website to a full operational system.</h2>
            </div>
            <p>Projects can start with one clearly defined problem and expand only where the business gains real value.</p>
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

<section class="section service-process-section">
    <div class="shell two-column">
        <div>
            <span class="kicker">How we approach custom work</span>
            <h2>Understand the process first, then design the software.</h2>
            <p class="section-copy">A useful custom system starts with the actual business rules, people, data and decisions behind the workflow—not with a generic feature list.</p>
        </div>
        <div class="service-process-list">
            <article><span>01</span><div><strong>Workflow discovery</strong><p>Map the current process, roles, approvals, data sources and reporting needs.</p></div></article>
            <article><span>02</span><div><strong>Solution design</strong><p>Define the modules, data model, integrations and user experience around the agreed scope.</p></div></article>
            <article><span>03</span><div><strong>Build & validate</strong><p>Develop in clear stages, test the important workflows and validate business rules with real scenarios.</p></div></article>
            <article><span>04</span><div><strong>Migrate & launch</strong><p>Prepare data, deployment, permissions, onboarding and the transition from the old process.</p></div></article>
            <article><span>05</span><div><strong>Improve over time</strong><p>Support upgrades, performance improvements, new reports, integrations and future modules as needs change.</p></div></article>
        </div>
    </div>
</section>

<section class="section seo-explainer-section">
    <div class="shell seo-explainer-card">
        <div>
            <span class="kicker">Modernization without unnecessary replacement</span>
            <h2>Existing software and data can often be improved instead of discarded.</h2>
        </div>
        <div>
            <p>If your organization already has a Laravel, PHP or database application, BusinessOS can review the current system and identify whether an upgrade, redesign, integration or staged migration is the better path.</p>
            <p>For spreadsheet-heavy operations, we can first structure the data and reporting model, then build automation around the parts that cause the most repeated work or errors.</p>
        </div>
    </div>
</section>

<section class="section faq-section" id="services-faq">
    <div class="shell two-column faq-layout">
        <div>
            <span class="kicker">Common questions</span>
            <h2>What businesses usually ask before starting a software project.</h2>
            <p class="section-copy">Scope, migration and modernization are handled according to the current system and the outcome the business needs.</p>
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
        <span class="kicker">BusinessOS custom solutions</span>
        <h2>Tell us the process you want to improve.</h2>
        <p>Share the current workflow, system or data problem. We can determine whether the right answer is a website, custom application, ERP/MIS module, integration, migration or modernization project.</p>
        <div class="hero-actions centered-actions">
            <a class="button button-primary" href="{{ route('contact') }}">Discuss your requirements <span aria-hidden="true">→</span></a>
            <a class="button button-ghost" href="{{ route('apps.index') }}">View products</a>
        </div>
    </div>
</section>
@endsection
