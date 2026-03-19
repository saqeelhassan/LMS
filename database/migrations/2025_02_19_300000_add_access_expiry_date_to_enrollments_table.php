<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * "Golden date" for online access: as long as today <= access_expiry_date, student can access.
     * Updated when monthly fee invoice is paid (e.g. paid for Feb → expiry = end of Feb).
     */
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->date('access_expiry_date')->nullable()->after('completed_at')->comment('Online access until this date (inclusive); null = no access or legacy');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn('access_expiry_date');
        });
    }
};
