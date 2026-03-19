<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Raw log from biometric devices (ZKTeco/Hikvision).
     * Each scan is one row. Punch logic (check-in/check-out, late, ghost) is applied separately.
     */
    public function up(): void
    {
        Schema::create('biometric_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->comment('Resolved from machine user id when mapped');
            $table->string('machine_user_id', 50)->nullable()->comment('ID from device e.g. Student #1005');
            $table->string('device_id', 100)->nullable()->comment('Which gate/device');
            $table->dateTime('scan_time');
            $table->string('type', 20)->default('Fingerprint')->comment('Fingerprint, Face, Card');
            $table->timestamps();

            $table->index(['user_id', 'scan_time']);
            $table->index(['device_id', 'scan_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biometric_logs');
    }
};
