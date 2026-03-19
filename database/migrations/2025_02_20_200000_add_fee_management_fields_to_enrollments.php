<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->decimal('course_fee_total', 12, 2)->nullable()->after('monthly_fee');
            $table->string('discount_type', 20)->default('None')->after('course_fee_total')->comment('None, Percentage, Fixed');
            $table->decimal('discount_value', 12, 2)->nullable()->after('discount_type')->comment('e.g. 10 for 10%, or 500 for flat');
            $table->date('start_date')->nullable()->after('discount_value');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['course_fee_total', 'discount_type', 'discount_value', 'start_date', 'end_date']);
        });
    }
};
