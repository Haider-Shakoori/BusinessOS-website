<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiry_notes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('inquiry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('note');
            $table->timestamps();

            $table->index(['inquiry_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiry_notes');
    }
};
