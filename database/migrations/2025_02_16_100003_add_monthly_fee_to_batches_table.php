<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->decimal('monthly_fee', 12, 2)->nullable()->after('schedule_note')->comment('Default monthly fee for this batch; used for voucher generation if enrollment.monthly_fee is not set');
        });
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn('monthly_fee');
        });
    }
};
