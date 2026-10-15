<?php

namespace Tests\Feature;

use App\Models\PageVisit;
use App\Models\User;
use App\Services\SearchConsoleAnalytics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class AcquisitionAttributionTest extends TestCase
{
    use RefreshDatabase;

    private const BROWSER = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/140.0 Safari/537.36';

    public function test_new_campaign_visits_capture_source_and_explicit_keyword(): void
    {
        $this->withHeader('User-Agent', self::BROWSER)
            ->get('/pricing?utm_source=newsletter&utm_term=restaurant+software')
            ->assertOk();

        $this->assertDatabaseHas('page_visits', [
            'path' => '/pricing',
            'traffic_type' => 'human',
            'campaign_source' => 'newsletter',
            'search_keyword' => 'restaurant software',
        ]);
    }

    public function test_visible_search_terms_are_only_captured_from_known_search_domains(): void
    {
        $this->withHeaders([
            'User-Agent' => self::BROWSER,
            'Referer' => 'https://www.bing.com/search?q=field+sales+afghanistan',
        ])->get('/apps')->assertOk();

        $this->assertDatabaseHas('page_visits', [
            'referrer_host' => 'www.bing.com',
            'search_keyword' => 'field sales afghanistan',
        ]);

        $this->withHeaders([
            'User-Agent' => self::BROWSER,
            'Referer' => 'https://www.bing.com.evil.example/search?q=secret',
        ])->get('/pricing')->assertOk();

        $this->assertDatabaseHas('page_visits', [
            'referrer_host' => 'www.bing.com.evil.example',
            'search_keyword' => null,
        ]);
    }

    public function test_historical_referrers_are_included_without_guessing_old_keywords(): void
    {
        PageVisit::create([
            'visitor_id' => (string) Str::uuid(),
            'path' => '/pricing',
            'referrer_host' => 'google.com',
            'traffic_type' => 'legacy',
            'occurred_at' => now()->subDays(140),
        ]);
        PageVisit::create([
            'visitor_id' => (string) Str::uuid(),
            'path' => '/',
            'referrer_host' => 'chatgpt.com',
            'traffic_type' => 'human',
            'occurred_at' => now()->subDay(),
        ]);

        $this->actingAs($this->admin())->get('/admin/analytics?days=365')
            ->assertOk()
            ->assertSee('Referral sources and their keywords')
            ->assertSee('Keyword-based search impressions')
            ->assertSee('google.com')
            ->assertSee('chatgpt.com')
            ->assertSee('Not provided')
            ->assertSee('Historical / unclassified')
            ->assertViewHas('allVisits', 1)
            ->assertViewHas('legacyVisits', 1)
            ->assertViewHas('acquisitionSources', function ($rows) {
                return $rows->contains(fn ($row) => $row->source === 'google.com'
                    && $row->keyword === 'Not provided'
                    && $row->traffic_type === 'legacy'
                    && (int) $row->views === 1);
            });
    }

    public function test_search_console_returns_actual_keyword_and_landing_page_impressions(): void
    {
        $key = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        $this->assertNotFalse($key);
        openssl_pkey_export($key, $privateKey);
        $path = storage_path('framework/gsc-test-'.Str::uuid().'.json');
        file_put_contents($path, json_encode([
            'type' => 'service_account',
            'client_email' => 'search-reader@example-project.iam.gserviceaccount.com',
            'private_key_id' => (string) Str::uuid(),
            'private_key' => $privateKey,
        ]));

        try {
            config([
                'search_console.site_url' => 'sc-domain:businessos.af',
                'search_console.credentials_path' => $path,
            ]);
            Cache::flush();

            Http::fake([
                'https://oauth2.googleapis.com/token' => Http::response([
                    'access_token' => 'gsc-test-token', 'expires_in' => 3600,
                ]),
                'https://searchconsole.googleapis.com/*' => Http::sequence()
                    ->push(['rows' => [[
                        'keys' => ['afghanistan pos software'],
                        'impressions' => 1200, 'clicks' => 48, 'ctr' => 0.04, 'position' => 5.6,
                    ]]])
                    ->push(['rows' => [[
                        'keys' => ['afghanistan pos software', 'https://businessos.af/apps/pos'],
                        'impressions' => 850, 'clicks' => 30, 'ctr' => 0.035, 'position' => 6.2,
                    ]]]),
            ]);

            $this->actingAs($this->admin())->get('/admin/analytics?days=90')
                ->assertOk()
                ->assertSee('afghanistan pos software')
                ->assertSee('1,200')
                ->assertSee('https://businessos.af/apps/pos')
                ->assertViewHas('searchConsole', fn ($gsc) => $gsc['status'] === 'ready'
                    && $gsc['keywords'][0]['impressions'] === 1200
                    && $gsc['keyword_pages'][0]['clicks'] === 30);

            $this->assertSame('ready', app(SearchConsoleAnalytics::class)->report(90)['status']);
            Http::assertSentCount(3);
        } finally {
            @unlink($path);
        }
    }

    private function admin(): User
    {
        return User::create([
            'name' => 'Analytics Admin',
            'email' => Str::uuid().'@example.com',
            'password' => 'a-secure-admin-password',
            'is_admin' => true,
        ]);
    }
}
