<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('fee_type', 30)->default('monthly')->after('description')
                ->comment('monthly, admission, examination');
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->decimal('arrears', 12, 2)->default(0)->after('course_fee_total')
                ->comment('Previous balance / past dues carried forward');
            $table->decimal('admission_fee', 12, 2)->nullable()->after('arrears');
            $table->decimal('examination_fee', 12, 2)->nullable()->after('admission_fee');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->string('status', 20)->default('approved')->after('recorded_by')
                ->comment('pending_approval, approved, rejected');
            $table->timestamp('approved_at')->nullable()->after('status');
            $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('users')->nullOnDelete();
            $table->string('bank_reference', 100)->nullable()->after('reference')
                ->comment('Bank deposit/transfer reference');
            $table->date('bank_deposit_date')->nullable()->after('bank_reference');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', fn (Blueprint $table) => $table->dropColumn('fee_type'));
        Schema::table('enrollments', fn (Blueprint $table) => $table->dropColumn(['arrears', 'admission_fee', 'examination_fee']));
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['status', 'approved_at', 'approved_by', 'bank_reference', 'bank_deposit_date']);
        });
    }
};
