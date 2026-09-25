<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guides', function (Blueprint $table): void {
            $table->string('author_name', 190)->nullable()->after('content');
            $table->string('author_role', 190)->nullable()->after('author_name');
            $table->text('author_bio')->nullable()->after('author_role');
        });
    }

    public function down(): void
    {
        Schema::table('guides', function (Blueprint $table): void {
            $table->dropColumn(['author_name', 'author_role', 'author_bio']);
        });
    }
};
