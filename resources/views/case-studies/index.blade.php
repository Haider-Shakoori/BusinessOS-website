@extends('layouts.marketing')

@section('content')
<section class="page-hero resource-hero">
    <div class="shell narrow-shell">
        <span class="kicker">{{ __('marketing.ui.case_studies.title') }}</span>
        <h1>{{ __('marketing.ui.case_studies.hero') }}</h1>
        <p>{{ __('marketing.ui.case_studies.lead') }}</p>
    </div>
</section>

<section class="section resource-section">
    <div class="shell">
        @if($caseStudies->count())
            <div class="resource-grid">
                @foreach($caseStudies as $caseStudy)
                    <article class="resource-card">
                        <div class="resource-card-top">
                            <span>{{ $caseStudy->industry }}</span>
                            <time datetime="{{ $caseStudy->published_at?->toDateString() }}">{{ $caseStudy->published_at?->locale(app()->getLocale())->translatedFormat('M j, Y') }}</time>
                        </div>
                        <h2><a href="{{ route('case-studies.show', $caseStudy) }}">{{ $caseStudy->title }}</a></h2>
                        <p>{{ $caseStudy->summary }}</p>
                        <a class="text-link" href="{{ route('case-studies.show', $caseStudy) }}">{{ __('marketing.ui.case_studies.read') }} <span>→</span></a>
                    </article>
                @endforeach
            </div>
            {{ $caseStudies->links() }}
        @else
            <div class="resource-empty">
                <span class="kicker">{{ __('marketing.ui.case_studies.empty_kicker') }}</span>
                <h2>{{ __('marketing.ui.case_studies.empty_title') }}</h2>
                <p>{{ __('marketing.ui.case_studies.empty_copy') }}</p>
            </div>
        @endif
    </div>
</section>
@endsection
