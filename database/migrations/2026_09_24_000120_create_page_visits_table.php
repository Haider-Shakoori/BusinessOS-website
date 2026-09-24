<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->uuid('visitor_id')->index();
            $table->string('path', 1000);
            $table->string('route_name', 120)->nullable()->index();
            $table->char('country_code', 2)->nullable()->index();
            $table->string('referrer_host', 255)->nullable();
            $table->string('user_agent_family', 80)->nullable();
            $table->timestamp('occurred_at')->index();

            $table->index(['country_code', 'occurred_at']);
            $table->index(['visitor_id', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
