<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_visits', function (Blueprint $table) {
            $table->string('campaign_source', 120)->nullable()->after('referrer_host');
            $table->string('search_keyword', 160)->nullable()->after('campaign_source');
        });

        // Existing page_visits remain untouched. Their original referrer_host
        // supports historical source reporting; unknown keywords stay NULL.
    }

    public function down(): void
    {
        Schema::table('page_visits', function (Blueprint $table) {
            $table->dropColumn(['campaign_source', 'search_keyword']);
        });
    }
};
