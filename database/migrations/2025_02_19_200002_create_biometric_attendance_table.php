<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Processed punch result per user per day (from biometric_logs).
     * Rule 1: First punch = Check-in. Rule 2: Last punch = Check-out.
     * Rule 3: Late if check-in > batch start + 15 min. Rule 4: Invalid if left within 10 min.
     * Kept separate from instructor_attendance/student_attendance until you sync.
     */
    public function up(): void
    {
        Schema::create('biometric_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            $table->dateTime('check_in_time')->nullable();
            $table->dateTime('check_out_time')->nullable();
            $table->string('status', 30)->default('Present')->comment('Present, Late, Invalid');
            $table->string('device_id', 100)->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biometric_attendance');
    }
};
