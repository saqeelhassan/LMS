<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->decimal('fees_collected', 12, 2)->default(0)->after('payment_status');
            $table->decimal('fees_due', 12, 2)->default(0)->after('fees_collected');
            $table->string('enrollment_status')->default('active')->after('fees_due')->comment('active, dropped');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['fees_collected', 'fees_due', 'enrollment_status']);
        });
    }
};
