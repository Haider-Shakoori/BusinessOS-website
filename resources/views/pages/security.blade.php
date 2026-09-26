@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero">
    <div class="shell narrow-shell">
        <span class="kicker">{{ __('marketing.ui.security.kicker') }}</span>
        <h1>{{ __('marketing.ui.security.title') }}</h1>
        <p>{{ __('marketing.ui.security.lead') }}</p>
    </div>
</section>

<section class="section trust-content-section">
    <div class="shell trust-card-grid security-grid">
        <article><span>01</span><h3>{{ __('marketing.ui.security.access') }}</h3><p>{{ __('marketing.ui.security.access_copy') }}</p></article>
        <article><span>02</span><h3>{{ __('marketing.ui.security.data') }}</h3><p>{{ __('marketing.ui.security.data_copy') }}</p></article>
        <article><span>03</span><h3>{{ __('marketing.ui.security.development') }}</h3><p>{{ __('marketing.ui.security.development_copy') }}</p></article>
        <article><span>04</span><h3>{{ __('marketing.ui.security.operations') }}</h3><p>{{ __('marketing.ui.security.operations_copy') }}</p></article>
    </div>
</section>

<section class="section trust-content-section muted-section">
    <div class="shell trust-content-grid">
        <aside><span class="story-index">{{ strtoupper(__('marketing.ui.security.specific')) }}</span></aside>
        <div class="prose-block">
            <h2>{{ __('marketing.ui.security.claims_title') }}</h2>
            <p>{{ __('marketing.ui.security.claims_copy') }}</p>
            <p>{{ __('marketing.ui.security.contact_copy') }}</p>
            <a class="text-link" href="{{ route('contact') }}">{{ __('marketing.ui.security.contact') }} <span>→</span></a>
        </div>
    </div>
</section>
@endsection
