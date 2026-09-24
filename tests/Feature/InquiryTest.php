<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_demo_request_is_stored(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Demo Request',
            'email' => 'demo@example.com',
            'company' => 'Example Company',
            'inquiry_type' => 'demo',
            'app_slug' => 'fieldpulse',
            'team_size' => '12 field users',
            'message' => 'We want to evaluate field attendance and client visit tracking.',
        ]);

        $response->assertSessionHas('inquiry_success');

        $this->assertDatabaseHas('inquiries', [
            'email' => 'demo@example.com',
            'inquiry_type' => 'demo',
            'app_slug' => 'fieldpulse',
        ]);

        $this->assertSame(1, Inquiry::query()->count());
    }

    public function test_honeypot_submission_is_rejected(): void
    {
        $response = $this->from('/contact')->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'inquiry_type' => 'contact',
            'message' => 'This looks like a valid message but should be rejected.',
            'website' => 'https://spam.example',
        ]);

        $response->assertRedirect('/contact')->assertSessionHasErrors('website');
        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_unknown_product_slug_is_rejected(): void
    {
        $response = $this->from('/request-demo')->post('/contact', [
            'name' => 'Product Request',
            'email' => 'person@example.com',
            'inquiry_type' => 'demo',
            'app_slug' => 'not-a-product',
            'message' => 'We want to discuss a product that is not in the BusinessOS catalog.',
        ]);

        $response->assertRedirect('/request-demo')->assertSessionHasErrors('app_slug');
        $this->assertDatabaseCount('inquiries', 0);
    }
}
