@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero legal-hero">
    <div class="shell narrow-shell">
        <span class="kicker">{{ __('marketing.ui.terms.kicker') }}</span>
        <h1>{{ __('marketing.ui.terms.title') }}</h1>
        <p>{{ __('marketing.ui.terms.lead') }}</p>
    </div>
</section>

<section class="section legal-section">
    <div class="shell legal-layout">
        <nav aria-label="Terms sections"><a href="#site">{{ __('marketing.ui.terms.site') }}</a><a href="#content">{{ __('marketing.ui.terms.content') }}</a><a href="#products">{{ __('marketing.ui.terms.products') }}</a><a href="#availability">{{ __('marketing.ui.terms.availability') }}</a><a href="#liability">{{ __('marketing.ui.terms.limitations') }}</a></nav>
        <div class="legal-copy">
            <section id="site"><h2>{{ __('marketing.ui.terms.site_title') }}</h2><p>{{ __('marketing.ui.terms.site_copy') }}</p></section>
            <section id="content"><h2>{{ __('marketing.ui.terms.content_title') }}</h2><p>{{ __('marketing.ui.terms.content_copy') }}</p></section>
            <section id="products"><h2>{{ __('marketing.ui.terms.products_title') }}</h2><p>{{ __('marketing.ui.terms.products_copy') }}</p></section>
            <section id="availability"><h2>{{ __('marketing.ui.terms.availability_title') }}</h2><p>{{ __('marketing.ui.terms.availability_copy') }}</p></section>
            <section id="liability"><h2>{{ __('marketing.ui.terms.limitations_title') }}</h2><p>{{ __('marketing.ui.terms.limitations_copy') }}</p></section>
            <section><h2>{{ __('marketing.ui.terms.contact_title') }}</h2><p>{{ __('marketing.ui.terms.contact_copy') }}</p><a class="text-link" href="{{ route('contact') }}">{{ __('marketing.ui.terms.contact') }} <span>→</span></a></section>
        </div>
    </div>
</section>
@endsection
