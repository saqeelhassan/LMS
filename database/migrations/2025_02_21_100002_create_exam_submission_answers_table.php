<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('exam_submission_answers')) {
            Schema::create('exam_submission_answers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('exam_submission_id')->constrained('exam_submissions')->cascadeOnDelete();
                $table->foreignId('exam_question_id')->constrained('exam_questions')->cascadeOnDelete();
                $table->string('selected_option', 1)->comment('a, b, c, or d');
                $table->timestamps();

                $table->unique(['exam_submission_id', 'exam_question_id'], 'exam_sub_ans_sub_que_unique');
            });
        } else {
            Schema::table('exam_submission_answers', function (Blueprint $table) {
                $table->unique(['exam_submission_id', 'exam_question_id'], 'exam_sub_ans_sub_que_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_submission_answers');
    }
};
