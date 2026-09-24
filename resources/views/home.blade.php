@extends('layouts.marketing')

@section('content')
<section class="calm-hero calm-hero-3d" id="top">
    <div class="shell calm-hero-grid">
        <div class="calm-hero-copy">
            <span class="calm-eyebrow">BusinessOS</span>
            <h1>Less friction.<br>More business.</h1>
            <p>Focused software for field teams and operations—designed to make daily work clearer, faster and easier to manage.</p>

            <div class="calm-hero-actions">
                <a class="button button-primary" href="{{ route('demo', ['app' => 'fieldpulse']) }}">See FieldPulse in action <span aria-hidden="true">→</span></a>
                <a class="button button-ghost" href="#products">Explore the product</a>
            </div>

            <div class="calm-trust-row" aria-label="BusinessOS product principles">
                <span><i></i> Simple to understand</span>
                <span><i></i> Fast on real networks</span>
                <span><i></i> Built for mobile work</span>
            </div>
        </div>

        <div class="calm-hero-visual calm-hero-scene" aria-label="FieldPulse product preview">
            <div class="calm-depth-plane calm-depth-plane-back" aria-hidden="true"></div>
            <div class="calm-depth-plane calm-depth-plane-mid" aria-hidden="true"></div>
            <div class="calm-window calm-window-3d">
                <div class="calm-window-top">
                    <div><i></i><i></i><i></i></div>
                    <strong>FieldPulse</strong>
                    <span>Today</span>
                </div>

                <div class="calm-window-body">
                    <aside aria-hidden="true">
                        <b>F</b>
                        <span class="active"></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </aside>

                    <main>
                        <header>
                            <div><small>GOOD MORNING</small><h2>Your field team</h2></div>
                            <em>Live</em>
                        </header>

                        <div class="calm-metrics">
                            <article><small>Active now</small><strong>18</strong><span>team members</span></article>
                            <article><small>Visits today</small><strong>42</strong><span>clients</span></article>
                            <article><small>Coverage</small><strong>76%</strong><span>territory</span></article>
                        </div>

                        <div class="calm-map">
                            <div class="calm-map-grid"></div>
                            <span class="route-one"></span>
                            <span class="route-two"></span>
                            <i class="pin-one"></i>
                            <i class="pin-two"></i>
                            <i class="pin-three"></i>
                            <i class="pin-four"></i>
                            <div class="calm-map-label"><b></b> Field activity</div>
                        </div>
                    </main>
                </div>
            </div>

            <div class="calm-float-card calm-float-one calm-float-3d">
                <span class="calm-float-icon">✓</span>
                <div><small>VISIT RECORDED</small><strong>Customer visit synced</strong></div>
            </div>
            <div class="calm-float-card calm-float-two calm-float-3d">
                <span class="calm-float-icon">↻</span>
                <div><small>OFFLINE MODE</small><strong>Ready to sync</strong></div>
            </div>
        </div>
    </div>
</section>

<section class="calm-signal-bar">
    <div class="shell">
        <span>Field sales</span>
        <span>Attendance</span>
        <span>Client visits</span>
        <span>Location visibility</span>
        <span>Management insight</span>
    </div>
</section>

<section class="calm-section calm-product" id="products">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">Featured product</span>
            <h2>A better way to manage field work.</h2>
        </div>
        <p>FieldPulse gives managers visibility without making field teams fight the software.</p>
    </div>

    <div class="shell calm-product-grid">
        <div class="calm-product-copy">
            <div class="calm-product-title">
                <div class="app-icon fieldpulse-icon" aria-hidden="true"><span></span><span></span></div>
                <div>
                    <small>{{ $featured['eyebrow'] }}</small>
                    <h3>{{ $featured['name'] }}</h3>
                </div>
            </div>

            <h4>{{ $featured['headline'] }}</h4>
            <p>{{ $featured['short_description'] }}</p>

            <div class="calm-feature-list">
                @foreach ($featured['highlights'] as $highlight)
                    <span><i>✓</i>{{ $highlight }}</span>
                @endforeach
            </div>

            <div class="calm-product-actions">
                <a class="button button-primary" href="{{ route('apps.show', $featured['slug']) }}">Explore FieldPulse <span>→</span></a>
                @if (!empty($featured['web_url']))
                    <a class="app-live-link compact" href="{{ $featured['web_url'] }}" target="_blank" rel="noopener noreferrer">
                        <span class="app-live-dot" aria-hidden="true"></span>
                        Open {{ parse_url($featured['web_url'], PHP_URL_HOST) }}
                        <span aria-hidden="true">↗</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="calm-phone-stage" aria-hidden="true">
            <div class="calm-phone">
                <div class="calm-phone-status"><span>9:41</span><i></i></div>
                <div class="calm-phone-brand"><b>F</b><span>FieldPulse</span></div>
                <small>WORK SESSION</small>
                <strong>06:42:18</strong>
                <em>Active</em>

                <div class="calm-phone-cards">
                    <span><small>Visits</small><b>7</b></span>
                    <span><small>Distance</small><b>18.2 km</b></span>
                </div>

                <div class="calm-phone-list">
                    <div><i></i><span><strong>Rahimi Pharmacy</strong><small>Visit complete</small></span><b>✓</b></div>
                    <div><i></i><span><strong>Kabul Market</strong><small>Next visit</small></span><b>→</b></div>
                </div>
            </div>
        </div>
    </div>

    @php($otherApps = $apps->where('featured', false))
    @if ($otherApps->count())
        <div class="shell calm-ecosystem">
            <div class="calm-ecosystem-head">
                <span class="calm-kicker">More BusinessOS apps</span>
                <a class="text-link" href="{{ route('apps.index') }}">View all apps <span>→</span></a>
            </div>
            <div class="calm-ecosystem-grid">
                @foreach ($otherApps as $app)
                    <article>
                        <div class="calm-ecosystem-top">
                            <div class="app-letter-icon" aria-hidden="true">{{ $app['icon_letter'] }}</div>
                            <span class="status-pill">{{ $app['status'] }}</span>
                        </div>
                        <span class="calm-app-kicker">{{ $app['eyebrow'] }}</span>
                        <h3>{{ $app['name'] }}</h3>
                        <p>{{ $app['short_description'] }}</p>
                        <div class="calm-ecosystem-actions">
                            <a class="text-link" href="{{ route('apps.show', $app['slug']) }}">Explore product <span>→</span></a>
                            @if (!empty($app['web_url']))
                                <a class="app-live-link" href="{{ $app['web_url'] }}" target="_blank" rel="noopener noreferrer">
                                    <span class="app-live-dot" aria-hidden="true"></span>
                                    {{ parse_url($app['web_url'], PHP_URL_HOST) }}
                                    <span aria-hidden="true">↗</span>
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
</section>

<section class="calm-section calm-outcomes" id="solutions">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">Why teams choose better software</span>
            <h2>Good software should make work feel lighter.</h2>
        </div>
        <p>The experience is designed around a few things people notice immediately: clarity, speed and confidence.</p>
    </div>

    <div class="shell calm-bento">
        <article class="calm-bento-large">
            <span class="calm-card-number">01</span>
            <h3>Know what is happening</h3>
            <p>See field activity, client visits and team progress without chasing updates across calls and messages.</p>
            <div class="calm-mini-chart" aria-hidden="true">
                <i style="height:32%"></i><i style="height:46%"></i><i style="height:57%"></i><i style="height:48%"></i><i style="height:72%"></i><i style="height:83%"></i><i style="height:91%"></i>
            </div>
        </article>

        <article>
            <span class="calm-card-number">02</span>
            <h3>Keep the team moving</h3>
            <p>Mobile workflows stay focused on what needs to happen next.</p>
            <div class="calm-check-stack" aria-hidden="true"><span>✓ Attendance</span><span>✓ Client visit</span><span>✓ Route sync</span></div>
        </article>

        <article>
            <span class="calm-card-number">03</span>
            <h3>Work through weak internet</h3>
            <p>Offline-aware product behavior keeps essential actions usable when connectivity is unreliable.</p>
            <div class="calm-signal-visual" aria-hidden="true"><span></span><span></span><span></span><b>Offline-ready</b></div>
        </article>
    </div>
</section>

<section class="calm-section calm-values" id="why-businessos">
    <div class="shell calm-values-grid">
        <div class="calm-values-intro">
            <span class="calm-kicker">Why BusinessOS</span>
            <h2>Designed to feel obvious.</h2>
            <p>People trust software faster when the interface feels familiar, predictable and calm. BusinessOS keeps the product focused so the technology gets out of the way.</p>
        </div>

        <div class="calm-value-list">
            <article><span>01</span><div><h3>Clear before clever</h3><p>Important actions are easy to find, understand and complete.</p></div></article>
            <article><span>02</span><div><h3>Fast by default</h3><p>Lightweight pages and practical mobile experiences keep response time low.</p></div></article>
            <article><span>03</span><div><h3>Built around the job</h3><p>Features exist because they support real workflows, not because they fill a checklist.</p></div></article>
        </div>
    </div>
</section>

<section class="calm-section calm-dark">
    <div class="shell calm-dark-grid">
        <div>
            <span class="calm-kicker">Built responsibly</span>
            <h2>Polished on the surface. Practical underneath.</h2>
            <p>BusinessOS keeps the marketing experience server-rendered and lightweight, while product workflows are designed for real devices and real network conditions.</p>
        </div>

        <div class="calm-dark-cards">
            <article><strong>Responsive</strong><span>Purposeful layouts for desktop, tablet and mobile.</span></article>
            <article><strong>Lightweight</strong><span>No heavy front-end framework required for core public pages.</span></article>
            <article><strong>Search-ready</strong><span>Structured, crawlable HTML and dedicated product pages.</span></article>
            <article><strong>Offline-aware</strong><span>Field workflows designed with imperfect connectivity in mind.</span></article>
        </div>
    </div>
</section>

<section class="calm-section calm-resources" id="resources">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">Resources</span>
            <h2>Useful ideas, without the noise.</h2>
        </div>
        <a class="text-link" href="{{ route('resources.index') }}">View all resources <span>→</span></a>
    </div>

    <div class="shell">
        @if ($latestGuides->count())
            <div class="calm-resource-grid">
                @foreach ($latestGuides as $guide)
                    <article>
                        <div class="calm-resource-meta">
                            <span>{{ $guide->category }}</span>
                            <time datetime="{{ $guide->published_at?->toDateString() }}">{{ $guide->published_at?->format('M j, Y') }}</time>
                        </div>
                        <h3><a href="{{ route('resources.show', $guide) }}">{{ $guide->title }}</a></h3>
                        <p>{{ $guide->excerpt }}</p>
                        <a class="text-link" href="{{ route('resources.show', $guide) }}">Read guide <span>→</span></a>
                    </article>
                @endforeach
            </div>
        @else
            <div class="calm-empty">
                <strong>Resources are being prepared.</strong>
                <span>Published guides will appear here automatically from the BusinessOS CMS.</span>
            </div>
        @endif
    </div>
</section>

<section class="calm-section calm-final">
    <div class="shell calm-final-card">
        <div>
            <span class="calm-kicker">FieldPulse</span>
            <h2>See whether it fits the way your team works.</h2>
            <p>Tell us how you manage field operations today and what you want to improve.</p>
        </div>
        <div class="calm-final-actions">
            <a class="button button-primary" href="{{ route('demo', ['app' => 'fieldpulse']) }}">Request a demo <span>→</span></a>
            <a class="button button-ghost" href="{{ route('apps.show', 'fieldpulse') }}">Explore FieldPulse</a>
        </div>
    </div>
</section>
@endsection
