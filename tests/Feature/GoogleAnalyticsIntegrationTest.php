<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\GoogleAnalytics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class GoogleAnalyticsIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_tag_is_only_included_for_public_non_excluded_visitors(): void
    {
        config(['ga4.measurement_id' => 'G-TEST12345']);

        $this->get('/')->assertOk()
            ->assertSee('googletagmanager.com/gtag/js?id=G-TEST12345', false);

        $this->withCookie('bos_internal', '1')->get('/')
            ->assertOk()
            ->assertDontSee('googletagmanager.com/gtag/js?', false);

        $admin = $this->admin();
        $this->actingAs($admin)->get('/')
            ->assertOk()
            ->assertDontSee('googletagmanager.com/gtag/js?', false);

        $this->get('/admin')->assertOk()
            ->assertDontSee('googletagmanager.com/gtag/js?', false);
    }

    public function test_google_analytics_configuration_is_visible_without_a_private_key(): void
    {
        config([
            'ga4.measurement_id' => '',
            'ga4.property_id' => '',
            'ga4.credentials_path' => '',
        ]);

        $admin = $this->admin();
        $this->actingAs($admin)->get('/admin')
            ->assertOk()
            ->assertSee('Google Analytics 4')
            ->assertSee('not configured yet');

        $this->get('/admin/analytics?days=7')
            ->assertOk()
            ->assertSee('Google Analytics 4')
            ->assertSee('GA4_PROPERTY_ID')
            ->assertSee('AI / LLM crawlers');
    }

    public function test_dashboard_reports_ga4_metrics_and_real_ai_referral_sessions(): void
    {
        $key = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        $this->assertNotFalse($key);
        openssl_pkey_export($key, $privateKey);
        $path = storage_path('framework/ga4-test-'.Str::uuid().'.json');

        file_put_contents($path, json_encode([
            'type' => 'service_account',
            'client_email' => 'ga4-reader@example-project.iam.gserviceaccount.com',
            'private_key_id' => 'test-'.Str::uuid(),
            'private_key' => $privateKey,
        ]));

        try {
            config([
                'ga4.measurement_id' => 'G-TEST12345',
                'ga4.property_id' => '123456789',
                'ga4.credentials_path' => $path,
            ]);
            Cache::flush();
            Http::fake([
                'https://oauth2.googleapis.com/token' => Http::response([
                    'access_token' => 'test-token', 'expires_in' => 3600,
                ], 200),
                'https://analyticsdata.googleapis.com/*' => Http::response([
                    'reports' => [
                        ['rows' => [['metricValues' => [
                            ['value' => '123'], ['value' => '175'], ['value' => '510'],
                            ['value' => '0.72'], ['value' => '5'],
                        ]]]],
                        ['rows' => [
                            ['dimensionValues' => [['value' => 'google']], 'metricValues' => [['value' => '100']]],
                            ['dimensionValues' => [['value' => 'chatgpt.com']], 'metricValues' => [['value' => '12']]],
                            ['dimensionValues' => [['value' => 'www.perplexity.ai']], 'metricValues' => [['value' => '7']]],
                            ['dimensionValues' => [['value' => 'chatgpt.com.fake-site.com']], 'metricValues' => [['value' => '2']]],
                        ]],
                        ['rows' => [[
                            'dimensionValues' => [['value' => '/apps/pos']],
                            'metricValues' => [['value' => '80']],
                        ]]],
                        ['rows' => [[
                            'dimensionValues' => [['value' => 'Afghanistan']],
                            'metricValues' => [['value' => '50']],
                        ]]],
                    ],
                ], 200),
            ]);

            $admin = $this->admin();
            $this->actingAs($admin)->get('/admin/analytics?days=7')
                ->assertOk()
                ->assertSee('AI REFERRAL SESSIONS')
                ->assertSee('chatgpt.com')
                ->assertSee('www.perplexity.ai')
                ->assertViewHas('ga4', function ($ga4) {
                    return $ga4['status'] === 'ready'
                        && $ga4['active_users'] === 123
                        && $ga4['sessions'] === 175
                        && $ga4['page_views'] === 510
                        && $ga4['ai_referral_sessions'] === 19
                        && $ga4['engagement_rate'] === 72.0;
                });

            // The overview shares cached 30-day reporting only with the same range.
            $report = app(GoogleAnalytics::class)->report(7);
            $this->assertSame(19, $report['ai_referral_sessions']);
            Http::assertSentCount(2);
        } finally {
            @unlink($path);
        }
    }

    public function test_failed_google_connection_does_not_break_cms(): void
    {
        config([
            'ga4.measurement_id' => 'G-TEST12345',
            'ga4.property_id' => '123456789',
            'ga4.credentials_path' => '/unavailable/private/ga4.json',
        ]);

        $this->actingAs($this->admin())->get('/admin/analytics')
            ->assertOk()
            ->assertSee('not configured yet');
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
