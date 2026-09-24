@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero legal-hero">
    <div class="shell narrow-shell">
        <span class="kicker">Terms</span>
        <h1>BusinessOS Website Terms of Use</h1>
        <p>Effective September 24, 2026. These terms cover use of the public BusinessOS marketing website. Product subscriptions and deployments may have separate commercial terms.</p>
    </div>
</section>

<section class="section legal-section">
    <div class="shell legal-layout">
        <nav aria-label="Terms sections"><a href="#site">Website use</a><a href="#content">Content</a><a href="#products">Products</a><a href="#availability">Availability</a><a href="#liability">Limitations</a></nav>
        <div class="legal-copy">
            <section id="site"><h2>Website use</h2><p>You may use this website to learn about BusinessOS and its products, request information and contact the BusinessOS team. You may not intentionally interfere with the website, attempt unauthorized access or use automated activity in a way that disrupts the service.</p></section>
            <section id="content"><h2>Content and intellectual property</h2><p>BusinessOS names, product names, visual design, original text and software materials are protected by applicable intellectual-property rights. Public website content may be referenced or linked to, but it is not a grant of ownership in the underlying products or brand assets.</p></section>
            <section id="products"><h2>Product information</h2><p>Features, availability, pricing and deployment details may change as products develop. Marketing pages describe current direction and capabilities but do not replace a signed commercial agreement or product-specific service terms.</p></section>
            <section id="availability"><h2>Website availability</h2><p>The public website may be changed, updated or temporarily unavailable. BusinessOS does not promise uninterrupted access to marketing pages or preview environments.</p></section>
            <section id="liability"><h2>Limitations</h2><p>The website is provided for general product information. To the extent permitted by applicable law, BusinessOS is not responsible for decisions made solely from informational website content without confirming the relevant product, commercial or technical details.</p></section>
            <section><h2>Contact</h2><p>Questions about these website terms can be submitted through the BusinessOS contact page.</p><a class="text-link" href="{{ route('contact') }}">Contact BusinessOS <span>→</span></a></section>
        </div>
    </div>
</section>
@endsection
