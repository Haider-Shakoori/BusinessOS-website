<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Services\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactChannelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_displays_click_to_call_whatsapp_and_email(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSee('Contact us directly')
            ->assertSee('href="tel:+93707413263"', false)
            ->assertSee('href="https://wa.me/93707413263"', false)
            ->assertSee('target="_blank" rel="noopener noreferrer"', false)
            ->assertSee('href="mailto:info@businessos.af"', false)
            ->assertSee('+93707413263')
            ->assertSee('info@businessos.af');
    }

    public function test_contact_links_use_editable_cms_values(): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'contact_phone'],
            ['group' => 'contact', 'value' => '+93 70 741 3263']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'contact_email'],
            ['group' => 'contact', 'value' => 'sales@example.com']
        );

        app(SiteSettings::class)->forget();

        $this->get('/contact')
            ->assertOk()
            ->assertSee('href="tel:+93707413263"', false)
            ->assertSee('href="https://wa.me/93707413263"', false)
            ->assertSee('href="mailto:sales@example.com"', false);
    }

    public function test_direct_contact_labels_are_localized(): void
    {
        $this->get('/contact?lang=fa')
            ->assertOk()
            ->assertSee('تماس مستقیم با ما')
            ->assertSee('https://wa.me/93707413263');

        $this->get('/contact?lang=ps')
            ->assertOk()
            ->assertSee('له موږ سره مستقیمه اړیکه')
            ->assertSee('https://wa.me/93707413263');
    }
}
