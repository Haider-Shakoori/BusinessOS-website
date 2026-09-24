@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero legal-hero">
    <div class="shell narrow-shell">
        <span class="kicker">Privacy</span>
        <h1>BusinessOS Privacy Policy</h1>
        <p>Effective September 24, 2026. This page describes the public BusinessOS website and inquiry forms. Individual products may require additional product-specific notices.</p>
    </div>
</section>

<section class="section legal-section">
    <div class="shell legal-layout">
        <nav aria-label="Privacy sections">
            <a href="#information">Information</a><a href="#analytics">Analytics</a><a href="#use">How it is used</a><a href="#retention">Retention</a><a href="#security">Security</a><a href="#choices">Your choices</a>
        </nav>
        <div class="legal-copy">
            <section id="information"><h2>Information we receive</h2><p>When you submit a contact, sales or demo request, we receive the information you choose to provide, such as your name, email address, company, phone number, team context and message. The website may also retain limited technical information needed for security and request handling, such as a protected representation of the submitting IP address, user agent and referring page.</p></section>
            <section id="analytics"><h2>First-party website analytics</h2><p>BusinessOS records first-party page-view analytics to understand website usage. A first-party anonymous visitor identifier is stored in a browser cookie so the CMS can distinguish unique visitors from total page views. For each tracked visit, BusinessOS may record the requested path, timestamp, route name, referring host, browser family and a two-letter country code when the hosting provider or CDN supplies one.</p><p>Analytics does not store the visitor&#039;s raw IP address and does not send IP addresses to an external geolocation API. If no trusted country signal is available, the visit is grouped as Unknown.</p></section><section id="use"><h2>How we use it</h2><p>Inquiry information is used to respond to your request, understand product interest, improve the sales or demo conversation, protect forms from abuse and maintain an operational record of the request.</p><p>Website analytics is used to understand overall traffic, unique visits, country-level usage and which public pages are most useful. The current analytics implementation is first-party and is not an advertising network.</p></section>
            <section id="retention"><h2>Retention</h2><p>Inquiry records are retained for legitimate business follow-up and operational recordkeeping. Website analytics records are automatically pruned according to the configured retention period, which defaults to 400 days. The anonymous visitor cookie is also configured for up to 400 days unless it is cleared earlier by the visitor.</p></section>
            <section id="security"><h2>Security</h2><p>Reasonable technical and organizational safeguards are used to protect submitted information. No internet service can guarantee absolute security, so security claims are kept limited to controls that can be verified.</p></section>
            <section id="choices"><h2>Your choices</h2><p>You can choose not to submit optional information. You can also clear or block the BusinessOS analytics cookie through your browser settings, although doing so affects the accuracy of unique-visitor counting. For questions about information previously submitted through this website, use the contact page and provide enough context to identify the request.</p></section>
            <section><h2>Changes</h2><p>This policy may change as the website, analytics setup, contact workflows and BusinessOS products evolve. The effective date above will be updated when material changes are published.</p></section>
        </div>
    </div>
</section>
@endsection
