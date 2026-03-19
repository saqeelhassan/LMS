<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('publication_status', 30)->default('approved')->after('live_class_url')
                ->comment('draft, pending_approval, approved, rejected');
            $table->timestamp('submitted_for_approval_at')->nullable()->after('publication_status');
            $table->timestamp('approved_at')->nullable()->after('submitted_for_approval_at');
            $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('users')->nullOnDelete();
            $table->timestamp('rejected_at')->nullable()->after('approved_by');
            $table->foreignId('rejected_by')->nullable()->after('rejected_at')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropColumn([
                'publication_status', 'submitted_for_approval_at', 'approved_at',
                'approved_by', 'rejected_at', 'rejected_by',
            ]);
        });
    }
};
