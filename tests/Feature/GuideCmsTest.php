<?php

namespace Tests\Feature;

use App\Models\Guide;
use App\Models\User;
use Database\Seeders\GuideSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuideCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guide_seeder_creates_initial_published_library(): void
    {
        $this->seed(GuideSeeder::class);

        $this->assertDatabaseCount('guides', 6);
        $this->assertSame(6, Guide::published()->count());
        $this->assertDatabaseHas('guides', [
            'slug' => 'what-to-look-for-in-field-sales-tracking-software',
            'status' => 'published',
        ]);
        $this->assertDatabaseHas('guides', [
            'slug' => 'daily-closing-checklist-retail-shops',
            'status' => 'published',
        ]);
        $this->assertDatabaseHas('guides', [
            'slug' => 'quotation-to-payment-customer-record',
            'status' => 'published',
        ]);
    }

    public function test_published_guide_is_public_and_includes_article_schema(): void
    {
        $guide = $this->publishedGuide();

        $this->get('/resources')
            ->assertOk()
            ->assertSee($guide->title);

        $this->get('/guides/'.$guide->slug)
            ->assertOk()
            ->assertSee($guide->title)
            ->assertSee('Article')
            ->assertSee('BreadcrumbList');
    }

    public function test_published_guide_is_in_sitemap(): void
    {
        $guide = $this->publishedGuide();

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('/guides/'.$guide->slug, false);
    }

    public function test_draft_guide_is_not_public(): void
    {
        $guide = Guide::create([
            'title' => 'Private Draft',
            'slug' => 'private-draft',
            'category' => 'Draft',
            'excerpt' => 'This should remain private until it is published.',
            'content' => str_repeat('Draft content for the unpublished resource. ', 5),
            'status' => 'draft',
        ]);

        $this->get('/guides/'.$guide->slug)->assertNotFound();
        $this->get('/resources')->assertDontSee('Private Draft');
    }

    public function test_admin_can_create_publish_and_soft_delete_a_guide(): void
    {
        $admin = User::create([
            'name' => 'CMS Admin',
            'email' => 'admin@example.com',
            'password' => 'a-secure-admin-password',
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->post('/admin/guides', [
            'title' => 'A Practical Field Operations Guide',
            'slug' => '',
            'category' => 'Field Operations',
            'excerpt' => 'A focused guide created from the BusinessOS CMS for field operations teams.',
            'content' => str_repeat('Useful operational guidance written for a real business workflow. ', 5),
            'meta_title' => 'A Practical Field Operations Guide | BusinessOS',
            'meta_description' => 'A practical field operations guide published through the BusinessOS CMS.',
            'status' => 'published',
        ]);

        $guide = Guide::where('title', 'A Practical Field Operations Guide')->firstOrFail();

        $response->assertRedirect(route('admin.guides.edit', $guide));
        $this->assertSame('published', $guide->status);
        $this->assertNotNull($guide->published_at);

        $this->get('/guides/'.$guide->slug)
            ->assertOk()
            ->assertSee('A Practical Field Operations Guide');

        $this->actingAs($admin)
            ->delete(route('admin.guides.destroy', $guide))
            ->assertRedirect(route('admin.guides.index'));

        $this->assertSoftDeleted('guides', ['id' => $guide->id]);
        $this->get('/guides/'.$guide->slug)->assertNotFound();
    }

    private function publishedGuide(): Guide
    {
        return Guide::create([
            'title' => 'What to Look for in Field Sales Tracking Software',
            'slug' => 'what-to-look-for-in-field-sales-tracking-software',
            'category' => 'Software Guide',
            'excerpt' => 'A buyer-oriented checklist for evaluating field sales software around workflows and practical adoption.',
            'content' => str_repeat('Practical guidance for evaluating field sales software in real operating conditions. ', 5),
            'meta_title' => 'What to Look for in Field Sales Tracking Software | BusinessOS',
            'meta_description' => 'Evaluate field sales tracking software with a practical workflow-focused checklist.',
            'status' => 'published',
            'published_at' => now()->subMinute(),
        ]);
    }
}
