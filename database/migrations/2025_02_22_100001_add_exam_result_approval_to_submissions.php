<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_submissions', function (Blueprint $table) {
            $table->timestamp('result_approved_at')->nullable()->after('marked_at')
                ->comment('When instructor approved the result for finalization');
            $table->foreignId('result_approved_by')->nullable()->after('result_approved_at')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('exam_submissions', function (Blueprint $table) {
            $table->dropForeign(['result_approved_by']);
            $table->dropColumn(['result_approved_at', 'result_approved_by']);
        });
    }
};
