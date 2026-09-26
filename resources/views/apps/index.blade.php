@extends('layouts.marketing')

@section('content')
<section class="page-hero">
    <div class="shell narrow-shell">
        <div class="eyebrow"><span class="pulse-dot"></span> {{ __('marketing.ui.apps.eyebrow') }}</div>
        <h1>{{ __('marketing.ui.apps.title') }}</h1>
        <p>{{ __('marketing.ui.apps.lead') }}</p>
    </div>
</section>

<section class="section app-directory">
    <div class="shell">
        <div class="directory-meta">
            <span>{{ $apps->count() }} {{ $apps->count() === 1 ? __('marketing.ui.apps.application') : __('marketing.ui.apps.applications') }}</span>
            <span>{{ __('marketing.ui.apps.summary') }}</span>
        </div>

        <div class="directory-grid">
            @foreach ($apps as $app)
                <article class="directory-card">
                    <div class="directory-card-top">
                        <div class="app-letter-icon" aria-hidden="true">{{ $app['icon_letter'] }}</div>
                        <span class="status-pill">{{ $app['status'] }}</span>
                    </div>
                    <span class="kicker">{{ $app['eyebrow'] }}</span>
                    <h2>{{ $app['name'] }}</h2>
                    <p>{{ $app['short_description'] }}</p>
                    <div class="chip-row">
                        @foreach ($app['platforms'] as $platform)
                            <span>{{ $platform }}</span>
                        @endforeach
                    </div>
                    <div class="directory-actions">
                        <a class="text-link" href="{{ route('apps.show', $app['slug']) }}">{{ __('marketing.ui.apps.explore') }} {{ $app['name'] }} <span>→</span></a>
                    </div>
                </article>
            @endforeach

            <article class="directory-card future-card">
                <div class="future-mark" aria-hidden="true">+</div>
                <span class="kicker">{{ __('marketing.ui.apps.future_kicker') }}</span>
                <h2>{{ __('marketing.ui.apps.future_title') }}</h2>
                <p>{{ __('marketing.ui.apps.future_copy') }}</p>
            </article>
        </div>
    </div>
</section>
@endsection
