<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_visits', function (Blueprint $table) {
            $table->string('traffic_type', 24)->default('human')->after('device_type')->index();
            $table->string('bot_family', 120)->nullable()->after('traffic_type')->index();
        });

        // Rows collected before this migration cannot be classified reliably
        // because raw user agents and IP addresses were intentionally not stored.
        DB::table('page_visits')->update([
            'traffic_type' => 'legacy',
            'bot_family' => null,
        ]);
    }

    public function down(): void
    {
        Schema::table('page_visits', function (Blueprint $table) {
            $table->dropIndex(['traffic_type']);
            $table->dropIndex(['bot_family']);
            $table->dropColumn(['traffic_type', 'bot_family']);
        });
    }
};
