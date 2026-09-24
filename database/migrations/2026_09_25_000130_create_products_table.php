<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 190);
            $table->string('slug', 190)->unique();
            $table->string('icon_letter', 8)->default('A');
            $table->string('eyebrow', 190)->nullable();
            $table->string('headline', 255)->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('category', 80)->default('BusinessApplication');
            $table->string('application_category', 80)->default('BusinessApplication');
            $table->string('operating_system', 190)->default('Web');
            $table->json('platforms')->nullable();
            $table->string('status', 80)->nullable();
            $table->string('accent', 40)->nullable();
            $table->string('subdomain', 190)->nullable();
            $table->string('web_url', 2048)->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->boolean('show_on_homepage')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedInteger('homepage_order')->default(0);
            $table->string('publication_state', 30)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->string('seo_title', 190)->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->json('screenshots')->nullable();
            $table->json('content')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['publication_state', 'is_visible']);
            $table->index(['show_on_homepage', 'homepage_order']);
            $table->index(['sort_order', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
