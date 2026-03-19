<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds rejection note (reason shown to student) and flag for re-application eligibility.
     */
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->text('rejection_note')->nullable()->after('enrollment_status')
                ->comment('Admin-provided reason for rejection, e.g. "Missing CNIC copy" or "Ineligible for NAVTTC"');
            $table->boolean('is_eligible_for_reapplication')->default(true)->after('rejection_note')
                ->comment('When true, student can use "Apply Again" to resubmit this enrollment as pending.');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['rejection_note', 'is_eligible_for_reapplication']);
        });
    }
};
