@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero">
    <div class="shell narrow-shell">
        <span class="kicker">Pricing</span>
        <h1>Pricing should match the product and the way your team uses it.</h1>
        <p>BusinessOS does not publish invented numbers before product packaging is finalized. Each application can have its own pricing model based on the workflow, team size and deployment requirements.</p>
    </div>
</section>

<section class="section pricing-section">
    <div class="shell">
        <div class="pricing-grid">
            <article>
                <span class="pricing-label">STARTING MODEL</span>
                <h2>Team</h2>
                <p>For smaller teams adopting a BusinessOS application around a focused workflow.</p>
                <ul><li>Core product capabilities</li><li>Standard onboarding path</li><li>Product-specific user access</li></ul>
                <a class="button button-ghost" href="{{ route('contact', ['type' => 'sales']) }}">Discuss requirements</a>
            </article>
            <article class="featured">
                <span class="pricing-label">GROWING OPERATIONS</span>
                <h2>Business</h2>
                <p>For organizations that need broader team adoption, management visibility and operational configuration.</p>
                <ul><li>Expanded team usage</li><li>Operational configuration</li><li>Implementation discussion</li></ul>
                <a class="button button-primary" href="{{ route('demo') }}">Request a demo</a>
            </article>
            <article>
                <span class="pricing-label">ADVANCED NEEDS</span>
                <h2>Custom</h2>
                <p>For deployments that require additional integration, rollout planning or organization-specific requirements.</p>
                <ul><li>Deployment planning</li><li>Integration assessment</li><li>Custom scope review</li></ul>
                <a class="button button-ghost" href="{{ route('contact', ['type' => 'sales']) }}">Talk to sales</a>
            </article>
        </div>
        <p class="pricing-note">Exact pricing will be published per product when commercial packaging is finalized. No fabricated discounts, list prices or “starting at” amounts are shown.</p>
    </div>
</section>
@endsection
