<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Academic attendance: tracks if a student attended a specific class/batch.
     * Purpose: learning & academic records (Hybrid: Physical + Online).
     */
    public function up(): void
    {
        Schema::create('student_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('batch_id')->constrained('batches')->cascadeOnDelete();
            $table->date('date');
            $table->string('status', 20)->default('Present')->comment('Present, Absent, Late, Leave');
            $table->string('mode', 20)->default('Physical')->comment('Physical, Online');
            $table->foreignId('marked_by')->nullable()->constrained('users')->nullOnDelete()->comment('Instructor ID; null = System/auto');
            $table->timestamp('login_time')->nullable()->comment('For Online students');
            $table->timestamps();

            $table->unique(['student_id', 'batch_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_attendance');
    }
};
