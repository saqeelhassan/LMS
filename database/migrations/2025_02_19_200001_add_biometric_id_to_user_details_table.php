<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * System ID assigned on the biometric device (e.g. 1005). Device sends this; we resolve to user_id.
     */
    public function up(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('biometric_id', 50)->nullable()->unique()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('biometric_id');
        });
    }
};
