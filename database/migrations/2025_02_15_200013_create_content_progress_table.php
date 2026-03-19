<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_content_id')->constrained('course_contents')->cascadeOnDelete();
            $table->unsignedInteger('last_position_seconds')->nullable()->comment('For video resume');
            $table->timestamp('last_watched_at')->nullable();
            $table->boolean('completed')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'course_content_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_progress');
    }
};
