<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreignId('batch_id')->nullable()->after('course_id')->constrained('batches')->nullOnDelete();
            $table->foreignId('instructor_id')->nullable()->after('batch_id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropForeign(['instructor_id']);
            $table->dropColumn(['batch_id', 'instructor_id']);
        });
    }
};
