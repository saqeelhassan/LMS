<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('answer_content')->nullable()->comment('Student written answer (offline exam)');
            $table->decimal('marks_obtained', 8, 2)->nullable()->comment('Instructor marks');
            $table->text('feedback')->nullable()->comment('Instructor feedback');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('marked_at')->nullable();
            $table->foreignId('marked_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('pending')->comment('pending, submitted, marked');
            $table->timestamps();

            $table->unique(['exam_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_submissions');
    }
};
