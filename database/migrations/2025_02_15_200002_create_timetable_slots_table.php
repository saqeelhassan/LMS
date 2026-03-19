<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timetable_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week')->comment('0=Sun, 1=Mon, ..., 6=Sat');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room')->nullable()->comment('e.g. Lab 3');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timetable_slots');
    }
};
