<?php

namespace Tests\Feature;

use App\Models\PageVisit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
                'occurred_at' => now(),
            ],
        ]);

        $response = $this->actingAs($admin)->get('/admin/analytics?days=30');

        $response
            ->assertOk()
            ->assertSee('Visitors by country')
            ->assertSee('Page views by country')
            ->assertSee('External referrers')
            ->assertSee('Landing pages')
            ->assertSee('Product pages people viewed')
            ->assertSee('Browser mix')
            ->assertSee('Device mix')
            ->assertSee('Afghanistan')
            ->assertSee('United States')
            ->assertSee('google.com')
            ->assertViewHas('uniqueVisits', 2)
            ->assertViewHas('allVisits', 3)
            ->assertViewHas('countryCoverage', 100)
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
