<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('title', 190);
            $table->string('slug', 190)->unique();
            $table->string('category', 80)->default('Guide')->index();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('meta_title', 190)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('status', 20)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
