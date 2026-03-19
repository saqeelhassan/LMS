<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Allow admins to mark a batch as government-funded and select the program (PITP, NAVTTC, BBSHRRDA).
     */
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->boolean('is_government_funded')->default(false)->after('is_active');
            $table->string('government_program', 50)->nullable()->after('is_government_funded')
                ->comment('PITP, NAVTTC, BBSHRRDA when is_government_funded');
        });
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn(['is_government_funded', 'government_program']);
        });
    }
};
