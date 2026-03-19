<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->foreignId('batch_id')->nullable()->after('course_id')->constrained('batches')->nullOnDelete();
            $table->foreignId('instructor_id')->nullable()->after('batch_id')->constrained('users')->nullOnDelete();
            $table->unsignedSmallInteger('duration_minutes')->nullable()->after('total_marks');
            $table->dateTime('start_datetime')->nullable()->after('due_date');
            $table->string('status', 20)->default('draft')->after('start_datetime')->comment('draft, published, completed');
        });
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropForeign(['instructor_id']);
            $table->dropColumn(['batch_id', 'instructor_id', 'duration_minutes', 'start_datetime', 'status']);
        });
    }
};
