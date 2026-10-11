@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero legal-hero">
    <div class="shell narrow-shell">
        <span class="kicker">{{ __('marketing.ui.privacy.kicker') }}</span>
        <h1>{{ __('marketing.ui.privacy.title') }}</h1>
        <p>{{ __('marketing.ui.privacy.lead') }}</p>
    </div>
</section>

<section class="section legal-section">
    <div class="shell legal-layout">
        <nav aria-label="Privacy sections">
            <a href="#information">{{ __('marketing.ui.privacy.information') }}</a><a href="#analytics">{{ __('marketing.ui.privacy.analytics') }}</a><a href="#use">{{ __('marketing.ui.privacy.use') }}</a><a href="#retention">{{ __('marketing.ui.privacy.retention') }}</a><a href="#security">{{ __('marketing.ui.privacy.security') }}</a><a href="#choices">{{ __('marketing.ui.privacy.choices') }}</a>
        </nav>
        <div class="legal-copy">
            <section id="information"><h2>{{ __('marketing.ui.privacy.information_title') }}</h2><p>{{ __('marketing.ui.privacy.information_copy') }}</p></section>
            <section id="analytics"><h2>{{ __('marketing.ui.privacy.analytics_title') }}</h2><p>{{ __('marketing.ui.privacy.analytics_copy_1') }}</p><p>{{ __('marketing.ui.privacy.analytics_copy_2') }}</p>
                @if (app(\App\Services\GoogleAnalytics::class)->measurementEnabled())
                    <p>We use Google Analytics 4 to measure page views and general referrals, subject to your choice and applicable privacy requirements. The Google tag may set cookies. You can opt out or change this preference below. BusinessOS first-party statistics are separate.</p>
                    <form method="POST" action="{{ route('analytics.preference') }}">
                        @csrf
                        <button type="submit" name="choice" value="yes">Allow Google Analytics</button>
                        <button type="submit" name="choice" value="no">Disable Google Analytics</button>
                    </form>
                    <p>Your current Google Analytics choice: {{ request()->cookie('bos_ga4_choice') === 'yes' ? 'Allowed' : (request()->cookie('bos_ga4_choice') === 'no' ? 'Disabled' : 'Not chosen') }}.</p>
                @endif
            </section><section id="use"><h2>{{ __('marketing.ui.privacy.use_title') }}</h2><p>{{ __('marketing.ui.privacy.use_copy_1') }}</p><p>{{ __('marketing.ui.privacy.use_copy_2') }}</p></section>
            <section id="retention"><h2>{{ __('marketing.ui.privacy.retention_title') }}</h2><p>{{ __('marketing.ui.privacy.retention_copy') }}</p></section>
            <section id="security"><h2>{{ __('marketing.ui.privacy.security_title') }}</h2><p>{{ __('marketing.ui.privacy.security_copy') }}</p></section>
            <section id="choices"><h2>{{ __('marketing.ui.privacy.choices_title') }}</h2><p>{{ __('marketing.ui.privacy.choices_copy') }}</p></section>
            <section><h2>{{ __('marketing.ui.privacy.changes_title') }}</h2><p>{{ __('marketing.ui.privacy.changes_copy') }}</p></section>
        </div>
    </div>
</section>
@endsection
