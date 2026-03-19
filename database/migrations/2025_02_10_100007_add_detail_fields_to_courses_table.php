<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->date('release_date')->nullable()->after('description');
            $table->string('total_hours', 50)->nullable()->after('release_date'); // e.g. "4h 50m"
            $table->boolean('certificate')->default(true)->after('total_hours');
            $table->string('skills', 255)->nullable()->after('certificate'); // e.g. "All level"
            $table->unsignedInteger('total_lectures')->nullable()->after('skills');
            $table->string('language', 100)->nullable()->after('total_lectures');
            $table->foreignId('instructor_id')->nullable()->after('language')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);
            $table->dropColumn([
                'release_date',
                'total_hours',
                'certificate',
                'skills',
                'total_lectures',
                'language',
                'instructor_id',
            ]);
        });
    }
};
