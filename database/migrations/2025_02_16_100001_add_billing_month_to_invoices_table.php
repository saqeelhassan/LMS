<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->date('billing_month')->nullable()->after('due_date')->comment('First day of month for monthly fee voucher; null = ad-hoc invoice');
        });

        // One voucher per enrollment per month (only when both are set)
        Schema::table('invoices', function (Blueprint $table) {
            $table->unique(['enrollment_id', 'billing_month'], 'invoices_enrollment_billing_month_unique');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropUnique('invoices_enrollment_billing_month_unique');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('billing_month');
        });
    }
};
