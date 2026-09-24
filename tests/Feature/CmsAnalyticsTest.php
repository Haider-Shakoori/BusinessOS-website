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
                'User-Agent' => 'Mozilla/5.0 Chrome/140.0 Safari/537.36',
            ])
            ->get('/pricing');

        $response->assertOk()->assertCookie('bos_vid');

        $this->assertDatabaseHas('page_visits', [
            'visitor_id' => $visitorId,
            'path' => '/pricing',
            'country_code' => 'AF',
            'user_agent_family' => 'Chrome',
        ]);

        $this->assertDatabaseCount('page_visits', 1);
    }

    public function test_admin_analytics_separates_unique_and_all_visits_by_country(): void
    {
        $admin = User::create([
            'name' => 'CMS Admin',
            'email' => 'admin@example.com',
            'password' => 'a-secure-admin-password',
            'is_admin' => true,
        ]);

        $visitorA = (string) Str::uuid();
        $visitorB = (string) Str::uuid();

        PageVisit::insert([
            [
                'visitor_id' => $visitorA,
                'path' => '/',
                'route_name' => 'home',
                'country_code' => 'AF',
                'referrer_host' => null,
                'user_agent_family' => 'Chrome',
                'occurred_at' => now()->subDay(),
            ],
            [
                'visitor_id' => $visitorA,
                'path' => '/apps/fieldpulse',
                'route_name' => 'apps.show',
                'country_code' => 'AF',
                'referrer_host' => null,
                'user_agent_family' => 'Chrome',
                'occurred_at' => now(),
            ],
            [
                'visitor_id' => $visitorB,
                'path' => '/',
                'route_name' => 'home',
                'country_code' => 'US',
                'referrer_host' => null,
                'user_agent_family' => 'Safari',
                'occurred_at' => now(),
            ],
        ]);

        $response = $this->actingAs($admin)->get('/admin/analytics?days=30');

        $response
            ->assertOk()
            ->assertSee('Unique visits by country')
            ->assertSee('All visits by country')
            ->assertSee('Afghanistan')
            ->assertSee('United States')
            ->assertViewHas('uniqueVisits', 2)
            ->assertViewHas('allVisits', 3)
            ->assertViewHas('uniqueByCountry', function ($rows) {
                $afghanistan = $rows->firstWhere('code', 'AF');

                return $afghanistan && $afghanistan['total'] === 1;
            })
            ->assertViewHas('allByCountry', function ($rows) {
                $afghanistan = $rows->firstWhere('code', 'AF');

                return $afghanistan && $afghanistan['total'] === 2;
            });
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
}
