<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamSubmission;
use App\Models\ExamSubmissionAnswer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $myBatchIds = $user->enrollments()->where('enrollment_status', 'active')->pluck('batch_id')->filter()->unique()->values()->all();
        $enrolledCourseIds = $user->enrollments()->pluck('course_id')->unique()->values()->all();

        $exams = Exam::query()
            ->where(function ($q) use ($myBatchIds, $enrolledCourseIds) {
                if (! empty($myBatchIds)) {
                    $q->whereIn('batch_id', $myBatchIds);
                }
                // Legacy: exams without batch_id visible to anyone in that course
                $q->orWhere(function ($q2) use ($enrolledCourseIds) {
                    $q2->whereNull('batch_id')->whereIn('course_id', $enrolledCourseIds);
                });
            })
            ->where(function ($q) {
                $q->whereIn('status', ['published', 'completed'])->orWhereNull('status');
            })
            ->with(['course', 'batch', 'submissions' => fn ($q) => $q->where('user_id', $user->id)])
            ->latest()
            ->paginate(10);

        return view('student.exam.index', compact('exams'));
    }

    public function submitForm(Exam $exam): View|RedirectResponse
    {
        $user = auth()->user();
        $enrollment = $user->enrollments()->where('course_id', $exam->course_id)->first();
        if (! $enrollment) {
            abort(403, 'You are not enrolled in this course.');
        }
        // Batch-based: must be in same batch if exam is batch-scoped
        if ($exam->batch_id && $enrollment->batch_id != $exam->batch_id) {
            abort(403, 'This exam is not for your batch.');
        }

        $submission = ExamSubmission::firstOrCreate(
            ['exam_id' => $exam->id, 'user_id' => $user->id],
            ['status' => 'pending']
        );

        if ($submission->isResultFinalized()) {
            return redirect()->route('student.exams.index')->with('info', 'Your result has been finalized.');
        }

        $exam->load(['course', 'questions']);
        $existingAnswers = $submission->submissionAnswers()->get()->keyBy('exam_question_id');

        return view('student.exam.submit', compact('exam', 'submission', 'existingAnswers'));
    }

    public function submit(Request $request, Exam $exam): RedirectResponse
    {
        $user = auth()->user();
        $enrollment = $user->enrollments()->where('course_id', $exam->course_id)->first();
        if (! $enrollment) {
            abort(403, 'You are not enrolled in this course.');
        }
        if ($exam->batch_id && $enrollment->batch_id != $exam->batch_id) {
            abort(403, 'This exam is not for your batch.');
        }

        $validated = $request->validate([
            'answer_content' => ['required', 'string', 'max:50000'],
        ]);

        $submission = ExamSubmission::firstOrCreate(
            ['exam_id' => $exam->id, 'user_id' => $user->id],
            ['status' => 'pending']
        );

        if ($submission->status === 'marked') {
            return redirect()->route('student.exams.index')->with('info', 'This exam has already been marked.');
        }

        $exam->load('questions');

        if ($exam->isMcq()) {
            $questionIds = $exam->questions->pluck('id')->all();
            $rules = ['answers' => ['required', 'array']];
            foreach ($questionIds as $id) {
                $rules['answers.' . $id] = ['required', 'string', 'in:a,b,c,d'];
            }
            $validated = $request->validate($rules);
            $answers = $request->input('answers', []);
            foreach ($answers as $qId => $option) {
                if (! in_array((int) $qId, $questionIds, true)) {
                    continue;
                }
                ExamSubmissionAnswer::updateOrCreate(
                    [
                        'exam_submission_id' => $submission->id,
                        'exam_question_id' => $qId,
                    ],
                    ['selected_option' => strtolower($option)]
                );
            }
            $marksObtained = 0;
            foreach ($exam->questions as $q) {
                $selected = $answers[$q->id] ?? null;
                if ($selected && $q->isCorrect($selected)) {
                    $marksObtained += $q->marks;
                }
            }
            $submission->update([
                'marks_obtained' => $marksObtained,
                'submitted_at' => now(),
                'status' => 'submitted',
            ]);
            return redirect()->route('student.exams.index')->with('success', 'MCQ submitted. Your result will be available after instructor approval.');
        }

        $validated = $request->validate([
            'answer_content' => ['required', 'string', 'max:50000'],
        ]);
        $submission->update([
            'answer_content' => $validated['answer_content'],
            'submitted_at' => now(),
            'status' => 'submitted',
        ]);

        return redirect()->route('student.exams.index')->with('success', 'Exam submitted successfully. Your instructor will mark it shortly.');
    }
}
