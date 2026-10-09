<section class="admin-panel analytics-bottom">
    <div class="admin-panel-head">
        <div><span>GOOGLE ANALYTICS 4</span><h2>Website acquisition and AI referrals</h2></div>
        <a href="https://analytics.google.com/" target="_blank" rel="noopener noreferrer">Open Google Analytics ↗</a>
    </div>

    @if ($ga4['status'] === 'ready')
        <p class="admin-panel-copy">GA4 session and engagement metrics for the last {{ $ga4['days'] }} days. These are separate from BusinessOS first-party analytics, so counts may differ.</p>
        <div class="admin-metric-grid analytics-metrics">
            <article><span>ACTIVE USERS</span><strong>{{ number_format($ga4['active_users']) }}</strong><small>GA4 users</small></article>
            <article><span>SESSIONS</span><strong>{{ number_format($ga4['sessions']) }}</strong><small>All sources</small></article>
            <article><span>PAGE VIEWS</span><strong>{{ number_format($ga4['page_views']) }}</strong><small>GA4 tracked views</small></article>
            <article><span>AI REFERRAL SESSIONS</span><strong>{{ number_format($ga4['ai_referral_sessions']) }}</strong><small>Known AI site referrals, not model citations</small></article>
        </div>
        <div class="admin-mini-features"><span>Engagement rate: {{ number_format($ga4['engagement_rate'], 1) }}%</span><span>Key events: {{ number_format($ga4['key_events']) }}</span></div>
        <div class="admin-panel-grid analytics-bottom">
            <section class="admin-panel">
                <div class="admin-panel-head"><div><span>ACQUISITION</span><h2>Top sources</h2></div></div>
                <div class="analytics-table">
                    <div class="analytics-table-head"><span>Source</span><span></span><span>Sessions</span></div>
                    @forelse ($ga4['sources'] as $item)
                        <div><span>{{ $item['label'] }}</span><b></b><b>{{ number_format($item['count']) }}</b></div>
                    @empty
                        <p class="analytics-empty">No acquisition data yet.</p>
                    @endforelse
                </div>
            </section>
            <section class="admin-panel">
                <div class="admin-panel-head"><div><span>AI DISCOVERY</span><h2>AI referral sources</h2></div></div>
                <div class="analytics-table">
                    <div class="analytics-table-head"><span>Platform</span><span></span><span>Sessions</span></div>
                    @forelse ($ga4['ai_referrers'] as $item)
                        <div><span>{{ $item['label'] }}</span><b></b><b>{{ number_format($item['count']) }}</b></div>
                    @empty
                        <p class="analytics-empty">No attributed AI referral sessions yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
        <p class="admin-panel-copy">A crawler request, AI citation, and AI referral are different events. GA4 can report attributable visits, but cannot count all private AI recommendations or visits that lose referral information.</p>
    @elseif ($ga4['status'] === 'unavailable')
        <p class="admin-panel-copy">Google Analytics reporting is temporarily unavailable. Your first-party analytics are unaffected. Verify the GA4 property ID, service-account Viewer access, Data API activation and server outbound HTTPS.</p>
    @else
        <p class="admin-panel-copy">GA4 reporting is not configured yet. Add GA4_PROPERTY_ID and a private GA4_CREDENTIALS_PATH on your server, enable the Google Analytics Data API and grant the service account Viewer access to the property.</p>
        <p class="admin-panel-copy">Public-site Google tag: {{ $ga4['measurement_enabled'] ? 'configured' : 'not configured (set GA4_MEASUREMENT_ID)' }}. Analytics reporting uses separate server-side credentials. See README for activation steps.</p>
    @endif
</section>
