<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Track attendance-based fines applied to enrollments.
     * Prevents double-counting when running the deduction command.
     */
    public function up(): void
    {
        Schema::create('attendance_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->date('period_start')->comment('e.g. first day of month');
            $table->date('period_end')->comment('e.g. last day of month');
            $table->unsignedInteger('absences_count')->default(0);
            $table->unsignedInteger('late_count')->default(0)->comment('Optional: late marked as half fine');
            $table->decimal('fine_per_absence', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();

            $table->unique(['enrollment_id', 'period_start'], 'attendance_deductions_enrollment_period_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_deductions');
    }
};
