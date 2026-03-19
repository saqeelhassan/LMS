<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $enrolledCourseIds = $user->enrollments()->pluck('course_id');
        $quizzes = Quiz::whereIn('course_id', $enrolledCourseIds)
            ->with('course')
            ->latest()
            ->paginate(15);

        $attemptsMap = QuizAttempt::where('user_id', $user->id)
            ->get()
            ->groupBy('quiz_id')
            ->map(fn ($attempts) => $attempts->sortByDesc('submitted_at')->first());

        return view('student.quiz.index', compact('quizzes', 'attemptsMap'));
    }

    public function start(Quiz $quiz): View|RedirectResponse
    {
        $user = auth()->user();
        if (! $user->enrollments()->where('course_id', $quiz->course_id)->exists()) {
            abort(403);
        }

        $now = Carbon::now();
        if ($quiz->opens_at && $now->lt($quiz->opens_at)) {
            return redirect()->route('student.quiz.index')->with('info', 'This quiz is not open yet.');
        }
        if ($quiz->closes_at && $now->gt($quiz->closes_at)) {
            return redirect()->route('student.quiz.index')->with('info', 'This quiz has closed.');
        }

        $quiz->load('questions');
        if ($quiz->questions->isEmpty()) {
            return redirect()->route('student.quiz.index')->with('info', 'No questions in this quiz.');
        }

        return view('student.quiz.take', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz): RedirectResponse
    {
        $user = auth()->user();
        if (! $user->enrollments()->where('course_id', $quiz->course_id)->exists()) {
            abort(403);
        }

        $quiz->load('questions');
        $answers = $request->input('answers', []);
        $score = 0;
        foreach ($quiz->questions as $q) {
            $selected = isset($answers[$q->id]) ? (int) $answers[$q->id] : -1;
            if ($selected === $q->correct_index) {
                $score++;
            }
        }
        $total = $quiz->questions->count();
        $percent = $total > 0 ? (int) round(100 * $score / $total) : 0;
        $passed = $percent >= $quiz->passing_percent;

        QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'answers' => $answers,
            'score' => $score,
            'total_questions' => $total,
            'percent' => $percent,
            'passed' => $passed,
            'started_at' => now(),
            'submitted_at' => now(),
        ]);

        $msg = $passed
            ? "You passed with {$score}/{$total} ({$percent}%)."
            : "You scored {$score}/{$total} ({$percent}%). Passing is {$quiz->passing_percent}%.";

        return redirect()->route('student.quiz.index')->with('success', $msg);
    }
}
