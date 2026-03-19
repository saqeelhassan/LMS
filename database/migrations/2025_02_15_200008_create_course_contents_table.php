<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('title');
            $table->string('type')->comment('video, pdf, code');
            $table->string('url')->nullable()->comment('Video URL or external link');
            $table->string('file_path')->nullable()->comment('Stored file path for PDF/code');
            $table->string('file_name')->nullable()->comment('Original filename');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_contents');
    }
};
