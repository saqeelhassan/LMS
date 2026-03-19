<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Payroll attendance: tracks instructor working hours for salary calculation.
     */
    public function up(): void
    {
        Schema::create('instructor_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            $table->timestamp('check_in_time')->nullable();
            $table->timestamp('check_out_time')->nullable();
            $table->string('status', 20)->default('Present')->comment('Present, Absent, Leave');
            $table->timestamps();

            $table->unique(['instructor_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructor_attendance');
    }
};
