@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['fa', 'ps'], true);
    $canonical = $meta['canonical'].($locale === 'en' ? '' : '?lang='.$locale);
    $ogImage = $siteSettings->get('og_image');
    $brandName = $siteSettings->get('brand_name', 'BusinessOS');
    $cmsLabel = static fn (string $key, string $fallback): string =>
        $locale === 'en' ? (string) $siteSettings->get($key, $fallback) : $fallback;
@endphp
<!doctype html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="color-scheme" content="light">
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <link rel="canonical" href="{{ $canonical }}">
    <link rel="alternate" hreflang="en" href="{{ $meta['canonical'] }}">
    <link rel="alternate" hreflang="fa-AF" href="{{ $meta['canonical'] }}?lang=fa">
    <link rel="alternate" hreflang="ps-AF" href="{{ $meta['canonical'] }}?lang=ps">
    <link rel="alternate" hreflang="x-default" href="{{ $meta['canonical'] }}">
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
    @if($siteSettings->get('google_site_verification'))<meta name="google-site-verification" content="{{ $siteSettings->get('google_site_verification') }}">@endif
    @if($siteSettings->get('bing_site_verification'))<meta name="msvalidate.01" content="{{ $siteSettings->get('bing_site_verification') }}">@endif

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $brandName }}">
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:url" content="{{ $canonical }}">
    @if($ogImage)
        <meta property="og:image" content="{{ str_starts_with($ogImage, 'http') ? $ogImage : url($ogImage) }}">
        <meta property="og:image:alt" content="{{ $meta['title'] }}">
    @endif
    <meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $meta['title'] }}">
    <meta name="twitter:description" content="{{ $meta['description'] }}">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/css/businessos.css') }}?v={{ filemtime(public_path('assets/css/businessos.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/businessos-calm.css') }}?v={{ filemtime(public_path('assets/css/businessos-calm.css')) }}">

    @foreach ($schema ?? [] as $entity)
        <script type="application/ld+json">{!! json_encode($entity, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    @endforeach
</head>
<body class="modern-site professional-light calm-premium {{ $isRtl ? 'rtl-site' : '' }}">
    <a class="skip-link" href="#main">{{ $locale === 'en' ? 'Skip to content' : ($locale === 'fa' ? 'رفتن به محتوا' : 'منځپانګې ته لاړ شئ') }}</a>

    <header class="site-header">
        <div class="shell nav-shell">
            <a class="brand" href="{{ route('home', $locale === 'en' ? [] : ['lang' => $locale]) }}" aria-label="{{ $brandName }} home">
                <span class="brand-mark" aria-hidden="true"><span></span><span></span><span></span></span>
                <span>{{ $brandName }}</span>
            </a>

            <nav class="desktop-nav" aria-label="Primary navigation">
                <a href="{{ route('home') }}{{ $locale === 'en' ? '' : '?lang='.$locale }}#products">{{ $cmsLabel('nav_products_label', __('marketing.nav.products')) }}</a>
                <a href="{{ route('services', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ $cmsLabel('nav_solutions_label', __('marketing.nav.solutions')) }}</a>
                <a href="{{ route('pricing', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ $cmsLabel('nav_pricing_label', __('marketing.nav.pricing')) }}</a>
                <a href="{{ route('resources.index', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ $cmsLabel('nav_resources_label', __('marketing.nav.resources')) }}</a>
                <a href="{{ route('about', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ $cmsLabel('nav_company_label', __('marketing.nav.company')) }}</a>
            </nav>

            <div class="nav-actions">
                <div class="locale-switcher" aria-label="{{ __('marketing.locale.label') }}">
                    @foreach(['en', 'fa', 'ps'] as $lang)
                        <a class="{{ $locale === $lang ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['lang' => $lang]) }}" lang="{{ $lang }}">{{ __('marketing.locale.'.$lang) }}</a>
                    @endforeach
                </div>
                <a class="button button-primary desktop-cta" href="{{ route('demo', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ $cmsLabel('nav_demo_label', __('marketing.nav.demo')) }}</a>
                <details class="mobile-menu">
                    <summary aria-label="Open navigation"><span></span><span></span><span></span></summary>
                    <nav aria-label="Mobile navigation">
                        <a href="{{ route('apps.index', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ $cmsLabel('nav_products_label', __('marketing.nav.products')) }}</a>
                        <a href="{{ route('services', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ $cmsLabel('nav_solutions_label', __('marketing.nav.solutions')) }}</a>
                        <a href="{{ route('pricing', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ $cmsLabel('nav_pricing_label', __('marketing.nav.pricing')) }}</a>
                        <a href="{{ route('resources.index', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ $cmsLabel('nav_resources_label', __('marketing.nav.resources')) }}</a>
                        <a href="{{ route('about', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ $cmsLabel('nav_company_label', __('marketing.nav.company')) }}</a>
                        <a href="{{ route('contact', $locale === 'en' ? [] : ['lang' => $locale]) }}">{{ __('marketing.nav.contact') }}</a>
                        <div class="mobile-locale-row">
                            @foreach(['en', 'fa', 'ps'] as $lang)
                                <a class="{{ $locale === $lang ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['lang' => $lang]) }}">{{ __('marketing.locale.'.$lang) }}</a>
                            @endforeach
                        </div>
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
                    <span>{{ $brandName }}</span>
                </a>
                <p>{{ $siteSettings->localized('footer_text', 'Focused business software for teams that value clarity, speed and practical workflows.') }}</p>
                @if($siteSettings->get('contact_email') || $siteSettings->get('contact_phone'))
                    <div class="footer-contact">
                        @if($siteSettings->get('contact_email'))<a href="mailto:{{ $siteSettings->get('contact_email') }}">{{ $siteSettings->get('contact_email') }}</a>@endif
                        @if($siteSettings->get('contact_phone'))<a href="tel:{{ $siteSettings->get('contact_phone') }}">{{ $siteSettings->get('contact_phone') }}</a>@endif
                    </div>
                @endif
            </div>
            <div class="footer-links">
                <div>
                    <strong>{{ __('marketing.footer.product') }}</strong>
                    <a href="{{ route('apps.index') }}">{{ __('marketing.nav.all_apps') }}</a>
                    @foreach($navProducts->take(4) as $product)
                        <a href="{{ route('apps.show', $product['slug']) }}">{{ $product['name'] }}</a>
                    @endforeach
                    <a href="{{ route('pricing') }}">{{ $cmsLabel('nav_pricing_label', __('marketing.nav.pricing')) }}</a>
                </div>
                <div>
                    <strong>{{ __('marketing.footer.company') }}</strong>
                    <a href="{{ route('services') }}">{{ $cmsLabel('nav_solutions_label', __('marketing.nav.solutions')) }}</a>
                    <a href="{{ route('about') }}">{{ __('marketing.footer.about') }}</a>
                    <a href="{{ route('security') }}">{{ __('marketing.footer.security') }}</a>
                    <a href="{{ route('contact') }}">{{ __('marketing.nav.contact') }}</a>
                </div>
                <div>
                    <strong>{{ __('marketing.footer.resources') }}</strong>
                    <a href="{{ route('resources.index') }}">{{ __('marketing.footer.guides') }}</a>
                    <a href="{{ route('case-studies.index') }}">Case studies</a>
                    <a href="{{ route('demo') }}">{{ $cmsLabel('nav_demo_label', __('marketing.nav.demo')) }}</a>
                </div>
                <div>
                    <strong>{{ __('marketing.footer.legal') }}</strong>
                    <a href="{{ route('privacy') }}">{{ __('marketing.footer.privacy') }}</a>
                    <a href="{{ route('terms') }}">{{ __('marketing.footer.terms') }}</a>
                </div>
            </div>
        </div>
        <div class="shell footer-bottom">
            <span>© {{ date('Y') }} {{ $brandName }}.</span>
            <span>{{ __('marketing.footer.built_for') }}</span>
        </div>
    </footer>
</body>
</html>
