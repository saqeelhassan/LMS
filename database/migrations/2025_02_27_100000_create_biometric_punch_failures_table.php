<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Failed punch attempts (unknown user, validation errors, etc.).
     * Keeps biometric_logs clean; failures can be purged or analyzed separately.
     */
    public function up(): void
    {
        Schema::create('biometric_punch_failures', function (Blueprint $table) {
            $table->id();
            $table->string('machine_user_id', 50)->nullable();
            $table->string('device_id', 100)->nullable();
            $table->dateTime('scan_time')->nullable();
            $table->string('type', 20)->nullable();
            $table->string('failure_reason', 100)->comment('unknown_user, validation_error, etc.');
            $table->text('raw_payload')->nullable()->comment('JSON of original request for debugging');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['failure_reason', 'created_at']);
            $table->index('scan_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biometric_punch_failures');
    }
};
