@extends('layouts.marketing')

@section('content')
<section class="page-hero resource-hero">
    <div class="shell narrow-shell">
        <span class="kicker">Case studies</span>
        <h1>How business problems are translated into software workflows.</h1>
        <p>Published case studies focus on the operational problem, implementation approach and verified outcome without inventing performance claims.</p>
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
                            <time datetime="{{ $caseStudy->published_at?->toDateString() }}">{{ $caseStudy->published_at?->format('M j, Y') }}</time>
                        </div>
                        <h2><a href="{{ route('case-studies.show', $caseStudy) }}">{{ $caseStudy->title }}</a></h2>
                        <p>{{ $caseStudy->summary }}</p>
                        <a class="text-link" href="{{ route('case-studies.show', $caseStudy) }}">Read case study <span>→</span></a>
                    </article>
                @endforeach
            </div>
            {{ $caseStudies->links() }}
        @else
            <div class="resource-empty">
                <span class="kicker">Case-study CMS ready</span>
                <h2>Verified implementation stories will appear here.</h2>
                <p>BusinessOS will publish case studies only when the problem, implementation and outcome can be described accurately.</p>
            </div>
        @endif
    </div>
</section>
@endsection
