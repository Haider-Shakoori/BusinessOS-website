<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 190);
            $table->string('company', 190)->nullable();
            $table->string('phone', 60)->nullable();
            $table->string('inquiry_type', 30);
            $table->string('app_slug', 100)->nullable()->index();
            $table->string('team_size', 80)->nullable();
            $table->text('message');
            $table->text('source_url')->nullable();
            $table->string('ip_hash')->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();

            $table->index(['inquiry_type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
