<?php

namespace Tests\Feature;

use App\Models\PageVisit;
use App\Models\User;
use App\Services\CountryResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class CmsAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_view_is_recorded_without_raw_ip_storage(): void
    {
        $visitorId = (string) Str::uuid();

        $response = $this
            ->withCookie('bos_vid', $visitorId)
            ->withHeaders([
                'CF-IPCountry' => 'AF',
                'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_0 like Mac OS X) AppleWebKit/605.1.15 Version/18.0 Mobile/15E148 Safari/604.1',
            ])
            ->get('/pricing');

        $response->assertOk()->assertCookie('bos_vid');

        $this->assertDatabaseHas('page_visits', [
            'visitor_id' => $visitorId,
            'path' => '/pricing',
            'country_code' => 'AF',
            'user_agent_family' => 'Safari',
            'device_type' => 'Mobile',
        ]);

        $this->assertDatabaseCount('page_visits', 1);
    }

    public function test_local_country_lookup_fallback_records_only_the_country_code(): void
    {
        $resolver = \Mockery::mock(CountryResolver::class);
        $resolver->shouldReceive('resolve')
            ->once()
            ->with('8.8.8.8')
            ->andReturn('US');

        $this->app->instance(CountryResolver::class, $resolver);

        $this
            ->withServerVariables(['REMOTE_ADDR' => '8.8.8.8'])
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 Chrome/140.0 Safari/537.36'])
            ->get('/pricing')
            ->assertOk()
            ->assertCookie('bos_country', 'US');

        $this->assertDatabaseHas('page_visits', [
            'country_code' => 'US',
            'device_type' => 'Desktop',
        ]);

        $this->assertNotContains('ip_address', Schema::getColumnListing('page_visits'));
    }

    public function test_automated_client_is_stored_separately_without_a_visitor_cookie(): void
    {
        $response = $this
            ->withHeaders([
                'CF-IPCountry' => 'US',
                'User-Agent' => 'Mozilla/5.0 Chrome/153.0 Mobile Safari/537.36 (compatible; GoogleOther)',
            ])
            ->get('/pricing');

        $response
            ->assertOk()
            ->assertCookieMissing('bos_vid');

        $this->assertDatabaseHas('page_visits', [
            'path' => '/pricing',
            'country_code' => 'US',
            'traffic_type' => 'search_crawler',
            'bot_family' => 'GoogleOther',
        ]);
    }

    public function test_internal_browser_cookie_prevents_tracking(): void
    {
        $this
            ->withCookie('bos_internal', '1')
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 Chrome/140.0 Safari/537.36'])
            ->get('/pricing')
            ->assertOk();

        $this->assertDatabaseCount('page_visits', 0);
    }

    public function test_admin_can_exclude_current_browser_and_purge_its_history(): void
    {
        $admin = $this->admin();
        $visitorId = (string) Str::uuid();

        PageVisit::create([
            'visitor_id' => $visitorId,
            'path' => '/',
            'route_name' => 'home',
            'country_code' => 'AF',
            'referrer_host' => null,
            'user_agent_family' => 'Chrome',
            'device_type' => 'Desktop',
            'occurred_at' => now(),
        ]);

        $response = $this
            ->actingAs($admin)
            ->withCookie('bos_vid', $visitorId)
            ->post('/admin/analytics/exclude-browser');

        $response
            ->assertRedirect('/admin/analytics')
            ->assertCookie('bos_internal', '1');

        $this->assertDatabaseMissing('page_visits', ['visitor_id' => $visitorId]);
    }

    public function test_admin_analytics_separates_visitors_page_views_and_acquisition_signals(): void
    {
        $admin = $this->admin();
        $visitorA = (string) Str::uuid();
        $visitorB = (string) Str::uuid();

        PageVisit::insert([
            [
                'visitor_id' => $visitorA,
                'path' => '/',
                'route_name' => 'home',
                'country_code' => 'AF',
                'referrer_host' => 'google.com',
                'user_agent_family' => 'Chrome',
                'device_type' => 'Desktop',
                'traffic_type' => 'human',
                'bot_family' => null,
                'occurred_at' => now()->subDay(),
            ],
            [
                'visitor_id' => $visitorA,
                'path' => '/apps/fieldpulse',
                'route_name' => 'apps.show',
                'country_code' => 'AF',
                'referrer_host' => 'businessos.af',
                'user_agent_family' => 'Chrome',
                'device_type' => 'Desktop',
                'traffic_type' => 'human',
                'bot_family' => null,
                'occurred_at' => now(),
            ],
            [
                'visitor_id' => $visitorB,
                'path' => '/apps/erp',
                'route_name' => 'apps.show',
                'country_code' => 'US',
                'referrer_host' => null,
                'user_agent_family' => 'Safari',
                'device_type' => 'Mobile',
                'traffic_type' => 'human',
                'bot_family' => null,
                'occurred_at' => now(),
            ],
            [
                'visitor_id' => (string) Str::uuid(),
                'path' => '/',
                'route_name' => 'home',
                'country_code' => 'US',
                'referrer_host' => null,
                'user_agent_family' => 'Chrome',
                'device_type' => 'Mobile',
                'traffic_type' => 'search_crawler',
                'bot_family' => 'GoogleOther',
                'occurred_at' => now(),
            ],
            [
                'visitor_id' => (string) Str::uuid(),
                'path' => '/pricing',
                'route_name' => 'pricing',
                'country_code' => 'US',
                'referrer_host' => null,
                'user_agent_family' => 'Other',
                'device_type' => 'Desktop',
                'traffic_type' => 'other_bot',
                'bot_family' => 'cURL',
                'occurred_at' => now(),
            ],
        ]);

        $response = $this->actingAs($admin)->get('/admin/analytics?days=30');

        $response
            ->assertOk()
            ->assertSee('Visitors by country')
            ->assertSee('Page views by country')
            ->assertSee('External referrers')
            ->assertSee('Where visitors entered')
            ->assertSee('Product pages human visitors viewed')
            ->assertSee('Browser mix')
            ->assertSee('Device mix')
            ->assertSee('Automated traffic by category')
            ->assertSee('GoogleOther')
            ->assertSee('cURL')
            ->assertSee('Afghanistan')
            ->assertSee('United States')
            ->assertSee('google.com')
            ->assertViewHas('uniqueVisits', 2)
            ->assertViewHas('allVisits', 3)
            ->assertViewHas('automatedHits', 2)
            ->assertViewHas('countryCoverage', 100)
            ->assertViewHas('trafficSummary', function ($rows) {
                return $rows->firstWhere('type', 'search_crawler')->total === 1
                    && $rows->firstWhere('type', 'other_bot')->total === 1;
            })
            ->assertViewHas('directVisits', 1)
            ->assertViewHas('uniqueByCountry', function ($rows) {
                $afghanistan = $rows->firstWhere('code', 'AF');

                return $afghanistan && $afghanistan['total'] === 1;
            })
            ->assertViewHas('allByCountry', function ($rows) {
                $afghanistan = $rows->firstWhere('code', 'AF');

                return $afghanistan && $afghanistan['total'] === 2;
            })
            ->assertViewHas('productInterest', fn ($rows) => $rows->contains(fn ($row) => $row->slug === 'fieldpulse'))
            ->assertViewHas('landingPages', fn ($rows) => $rows->contains(fn ($row) => $row->path === '/'));
    }

    public function test_cms_requires_an_admin_account(): void
    {
        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => 'a-secure-user-password',
            'is_admin' => false,
        ]);

        $this->get('/admin')->assertRedirect('/admin/login');
        $this->actingAs($regularUser)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_sign_in_to_cms(): void
    {
        User::create([
            'name' => 'CMS Admin',
            'email' => 'admin@example.com',
            'password' => 'a-secure-admin-password',
            'is_admin' => true,
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'a-secure-admin-password',
        ])->assertRedirect('/admin');

        $this->assertAuthenticated();
    }

    private function admin(): User
    {
        return User::create([
            'name' => 'CMS Admin',
            'email' => Str::uuid().'@example.com',
            'password' => 'a-secure-admin-password',
            'is_admin' => true,
        ]);
    }
}