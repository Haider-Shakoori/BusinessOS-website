<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#08090d">
    <meta name="color-scheme" content="dark">
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <link rel="canonical" href="{{ $meta['canonical'] }}">
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="BusinessOS">
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:url" content="{{ $meta['canonical'] }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta['title'] }}">
    <meta name="twitter:description" content="{{ $meta['description'] }}">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/css/businessos.css') }}?v={{ filemtime(public_path('assets/css/businessos.css')) }}">

    @foreach ($schema ?? [] as $entity)
        <script type="application/ld+json">{!! json_encode($entity, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    @endforeach
</head>
<body class="modern-site">
    <a class="skip-link" href="#main">Skip to content</a>

    <header class="site-header">
        <div class="shell nav-shell">
            <a class="brand" href="{{ route('home') }}" aria-label="BusinessOS home">
                <span class="brand-mark" aria-hidden="true">
                    <span></span><span></span><span></span>
                </span>
                <span>BusinessOS</span>
            </a>

            <nav class="desktop-nav" aria-label="Primary navigation">
                <a href="{{ route('home') }}#products">Products</a>
                <a href="{{ route('pricing') }}">Pricing</a>
                <a href="{{ route('resources.index') }}">Resources</a>
                <a href="{{ route('home') }}#why-businessos">Why BusinessOS</a>
                <a href="{{ route('about') }}">About</a>
            </nav>

            <div class="nav-actions">
                <a class="button button-ghost desktop-cta" href="{{ route('contact', ['type' => 'sales']) }}">Contact sales</a>
                <details class="mobile-menu">
                    <summary aria-label="Open navigation"><span></span><span></span><span></span></summary>
                    <nav aria-label="Mobile navigation">
                        <a href="{{ route('home') }}#products">Products</a>
                        <a href="{{ route('pricing') }}">Pricing</a>
                        <a href="{{ route('resources.index') }}">Resources</a>
                        <a href="{{ route('home') }}#why-businessos">Why BusinessOS</a>
                        <a href="{{ route('about') }}">About</a>
                        <a href="{{ route('contact') }}">Contact</a>
                    </nav>
                </details>
            </div>
        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="shell footer-grid">
            <div>
                <a class="brand footer-brand" href="{{ route('home') }}">
                    <span class="brand-mark" aria-hidden="true"><span></span><span></span><span></span></span>
                    <span>BusinessOS</span>
                </a>
                <p>Modern business software engineered to stay clear, fast and useful.</p>
            </div>
            <div class="footer-links">
                <div>
                    <strong>Product</strong>
                    <a href="{{ route('apps.index') }}">All apps</a>
                    <a href="{{ route('apps.show', 'fieldpulse') }}">FieldPulse</a>
                    <a href="{{ route('pricing') }}">Pricing</a>
                    <a href="{{ route('demo') }}">Request demo</a>
                </div>
                <div>
                    <strong>Company</strong>
                    <a href="{{ route('about') }}">About</a>
                    <a href="{{ route('security') }}">Security</a>
                    <a href="{{ route('contact') }}">Contact</a>
                </div>
                <div>
                    <strong>Resources</strong>
                    <a href="{{ route('resources.index') }}">Guides</a>
                    <a href="{{ route('resources.index') }}">Field operations</a>
                    <a href="{{ route('resources.index') }}">Software guides</a>
                </div>
                <div>
                    <strong>Legal</strong>
                    <a href="{{ route('privacy') }}">Privacy</a>
                    <a href="{{ route('terms') }}">Terms</a>
                </div>
            </div>
        </div>
        <div class="shell footer-bottom">
            <span>© {{ date('Y') }} BusinessOS.</span>
            <span>Built for real businesses and real networks.</span>
        </div>
    </footer>
</body>
</html>
