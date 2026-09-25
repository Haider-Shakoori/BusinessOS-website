<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table): void {
            $table->string('status', 30)->default('new')->after('message')->index();
            $table->timestamp('follow_up_at')->nullable()->after('status');
            $table->timestamp('resolved_at')->nullable()->after('follow_up_at');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table): void {
            $table->dropIndex(['status']);
            $table->dropColumn(['status', 'follow_up_at', 'resolved_at']);
        });
    }
};
