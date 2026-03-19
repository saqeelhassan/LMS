<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exam;
use Illuminate\Validation\Rule;
use App\Models\ExamQuestion;
use App\Models\ExamSubmission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    /** Exams Manager: list all exams across instructor's courses. */
    public function examsManagerIndex(Request $request): View
    {
        $user = auth()->user();
        $courseIds = Course::where('instructor_id', $user->id)->pluck('id');
        $query = Exam::whereIn('course_id', $courseIds)->with(['course', 'batch'])->withCount('submissions')->latest();
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        $exams = $query->paginate(15)->withQueryString();
        $courses = Course::where('instructor_id', $user->id)->orderBy('name')->get();

        return view('instructor.exam.exams-manager.index', compact('exams', 'courses'));
    }

    /** Exams Manager: create exam with course dropdown + question builder. */
    public function examsManagerCreate(): View|RedirectResponse
    {
        $user = auth()->user();
        $courses = Course::where('instructor_id', $user->id)->with(['batches' => fn ($q) => $q->where('is_active', true)->orderBy('name')])->orderBy('name')->get();
        if ($courses->isEmpty()) {
            return redirect()->route('instructor.exams-manager.index')->with('warning', 'You must have at least one course before creating exams.');
        }

        return view('instructor.exam.exams-manager.create', compact('courses'));
    }

    /** Exams Manager: store exam + questions in one request. */
    public function examsManagerStore(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $courseIds = Course::where('instructor_id', $user->id)->pluck('id')->toArray();
        $validated = $request->validate([
            'course_id' => ['required', 'integer', 'in:' . implode(',', $courseIds)],
            'batch_id' => ['nullable', 'integer', Rule::exists('batches', 'id')->where('course_id', $request->input('course_id'))],
            'title' => ['required', 'string', 'max:255'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:480'],
            'status' => ['nullable', 'string', 'in:draft,published,completed'],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.question_text' => ['required', 'string', 'max:2000'],
            'questions.*.option_a' => ['required', 'string', 'max:500'],
            'questions.*.option_b' => ['required', 'string', 'max:500'],
            'questions.*.option_c' => ['nullable', 'string', 'max:500'],
            'questions.*.option_d' => ['nullable', 'string', 'max:500'],
            'questions.*.correct_option' => ['required', 'string', 'in:a,b,c,d'],
            'questions.*.marks' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $totalMarks = collect($validated['questions'])->sum('marks');
        $exam = $course->exams()->create([
            'batch_id' => $validated['batch_id'] ?? null,
            'instructor_id' => $user->id,
            'created_by' => $user->id,
            'title' => $validated['title'],
            'total_marks' => $totalMarks,
            'passing_marks' => null,
            'duration_minutes' => $validated['duration_minutes'],
            'status' => $validated['status'] ?? 'draft',
        ]);

        foreach ($validated['questions'] as $i => $q) {
            $exam->questions()->create([
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'] ?? null,
                'option_d' => $q['option_d'] ?? null,
                'correct_option' => $q['correct_option'],
                'marks' => $q['marks'],
                'sort_order' => $i + 1,
            ]);
        }

        return redirect()->route('instructor.exams.questions.index', [$course, $exam])
            ->with('success', 'Exam created with ' . count($validated['questions']) . ' questions. Total marks: ' . $totalMarks . '.');
    }

    public function index(Course $course, Request $request): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $query = $course->exams()->with(['batch', 'course'])->withCount('submissions')->latest();
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }
        $exams = $query->paginate(10)->withQueryString();
        $batches = $course->batches()->where('is_active', true)->orderBy('name')->get();

        return view('instructor.exam.index', compact('course', 'exams', 'batches'));
    }

    public function create(Course $course): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $batches = $course->batches()->where('is_active', true)->orderBy('name')->get();
        if ($batches->isEmpty()) {
            return redirect()->route('instructor.exams.index', $course)
                ->with('warning', 'Create at least one batch for this course before adding exams.');
        }

        return view('instructor.exam.create', compact('course', 'batches'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $batches = $course->batches()->pluck('id')->toArray();
        $validated = $request->validate([
            'batch_id' => ['required', 'integer', 'in:' . implode(',', $batches)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'total_marks' => ['required', 'integer', 'min:1', 'max:1000'],
            'passing_marks' => ['nullable', 'integer', 'min:0'],
            'duration_minutes' => ['nullable', 'integer', 'min:1', 'max:480'],
            'start_datetime' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'in:draft,published,completed'],
        ]);

        $course->exams()->create([
            ...$validated,
            'batch_id' => $validated['batch_id'],
            'instructor_id' => auth()->id(),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('instructor.exams.index', $course)->with('success', 'Exam created successfully.');
    }

    public function questionsIndex(Course $course, Exam $exam): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($exam->course_id !== $course->id) {
            abort(404);
        }
        $exam->load('questions');
        return view('instructor.exam.questions', compact('course', 'exam'));
    }

    public function questionStore(Request $request, Course $course, Exam $exam): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($exam->course_id !== $course->id) {
            abort(404);
        }
        $validated = $request->validate([
            'question_text' => ['required', 'string', 'max:2000'],
            'option_a' => ['required', 'string', 'max:500'],
            'option_b' => ['required', 'string', 'max:500'],
            'option_c' => ['nullable', 'string', 'max:500'],
            'option_d' => ['nullable', 'string', 'max:500'],
            'correct_option' => ['required', 'string', 'in:a,b,c,d'],
            'marks' => ['required', 'integer', 'min:1', 'max:100'],
        ]);
        $nextOrder = $exam->questions()->max('sort_order') + 1;
        $exam->questions()->create([
            ...$validated,
            'sort_order' => $nextOrder,
        ]);
        return redirect()->route('instructor.exams.questions.index', [$course, $exam])
            ->with('success', 'Question added.');
    }

    public function questionEdit(Course $course, Exam $exam, ExamQuestion $question): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($exam->course_id !== $course->id || $question->exam_id !== $exam->id) {
            abort(404);
        }
        return view('instructor.exam.question-edit', compact('course', 'exam', 'question'));
    }

    public function questionUpdate(Request $request, Course $course, Exam $exam, ExamQuestion $question): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($exam->course_id !== $course->id || $question->exam_id !== $exam->id) {
            abort(404);
        }
        $validated = $request->validate([
            'question_text' => ['required', 'string', 'max:2000'],
            'option_a' => ['required', 'string', 'max:500'],
            'option_b' => ['required', 'string', 'max:500'],
            'option_c' => ['nullable', 'string', 'max:500'],
            'option_d' => ['nullable', 'string', 'max:500'],
            'correct_option' => ['required', 'string', 'in:a,b,c,d'],
            'marks' => ['required', 'integer', 'min:1', 'max:100'],
        ]);
        $question->update($validated);
        return redirect()->route('instructor.exams.questions.index', [$course, $exam])
            ->with('success', 'Question updated.');
    }

    public function questionDestroy(Course $course, Exam $exam, ExamQuestion $question): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($exam->course_id !== $course->id || $question->exam_id !== $exam->id) {
            abort(404);
        }
        $question->delete();
        return redirect()->route('instructor.exams.questions.index', [$course, $exam])
            ->with('success', 'Question removed.');
    }

    public function submissions(Course $course, Exam $exam): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($exam->course_id !== $course->id) {
            abort(404);
        }

        // Students in this exam's batch (batch-based visibility)
        $enrollments = $exam->batch_id
            ? $exam->batch->enrollments()->where('enrollment_status', 'active')->with('user.userDetail')->get()
            : $course->enrollments()->with('user.userDetail')->get();
        $enrolledUserIds = $enrollments->pluck('user_id');
        $submissions = ExamSubmission::where('exam_id', $exam->id)
            ->whereIn('user_id', $enrolledUserIds)
            ->with('user.userDetail')
            ->get()
            ->keyBy('user_id');

        $students = $enrollments->map(function ($e) use ($submissions) {
            return (object) [
                'user' => $e->user,
                'submission' => $submissions->get($e->user_id),
            ];
        });

        return view('instructor.exam.submissions', compact('course', 'exam', 'students'));
    }

    public function markForm(Course $course, Exam $exam, User $user): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($exam->course_id !== $course->id) {
            abort(404);
        }
        $allowed = $exam->batch_id
            ? $exam->batch->enrollments()->where('user_id', $user->id)->where('enrollment_status', 'active')->exists()
            : $course->enrollments()->where('user_id', $user->id)->exists();
        if (! $allowed) {
            abort(403, 'Student is not in this exam\'s batch.');
        }

        $submission = ExamSubmission::firstOrCreate(
            ['exam_id' => $exam->id, 'user_id' => $user->id],
            ['status' => 'pending']
        );
        $submission->load('user.userDetail');

        return view('instructor.exam.mark', compact('course', 'exam', 'submission'));
    }

    public function mark(Request $request, Course $course, Exam $exam, User $user): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($exam->course_id !== $course->id) {
            abort(404);
        }
        $allowed = $exam->batch_id
            ? $exam->batch->enrollments()->where('user_id', $user->id)->where('enrollment_status', 'active')->exists()
            : $course->enrollments()->where('user_id', $user->id)->exists();
        if (! $allowed) {
            abort(403, 'Student is not in this exam\'s batch.');
        }

        $submission = ExamSubmission::firstOrCreate(
            ['exam_id' => $exam->id, 'user_id' => $user->id],
            ['status' => 'pending']
        );

        $maxMarks = $exam->isMcq() ? $exam->total_marks_from_questions : $exam->total_marks;
        $validated = $request->validate([
            'marks_obtained' => ['required', 'numeric', 'min:0', 'max:' . $maxMarks],
            'feedback' => ['nullable', 'string', 'max:2000'],
        ]);

        $submission->update([
            'marks_obtained' => $validated['marks_obtained'],
            'feedback' => $validated['feedback'] ?? null,
            'marked_at' => now(),
            'marked_by' => auth()->id(),
            'status' => 'marked',
        ]);

        return redirect()->route('instructor.exams.submissions', [$course, $exam])
            ->with('success', 'Submission marked. Approve to finalize the result for the student.');
    }

    /** Approve result so student can see their marks (finalization). */
    public function approveResult(Request $request, Course $course, Exam $exam, User $user): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($exam->course_id !== $course->id) {
            abort(404);
        }

        $submission = ExamSubmission::where('exam_id', $exam->id)->where('user_id', $user->id)->first();
        $canApprove = $submission
            && $submission->marks_obtained !== null
            && ! $submission->isResultFinalized()
            && in_array($submission->status, ['marked', 'submitted'], true);
        if (! $canApprove) {
            return redirect()->back()->with('info', 'Result must be marked (or MCQ auto-graded) before approval.');
        }
        if ($submission->isResultFinalized()) {
            return redirect()->back()->with('info', 'Result is already approved.');
        }

        $submission->update([
            'result_approved_at' => now(),
            'result_approved_by' => auth()->id(),
        ]);

        return redirect()->route('instructor.exams.submissions', [$course, $exam])
            ->with('success', 'Result approved and finalized for the student.');
    }


    private function authorizeInstructorCourse(Course $course): void
    {
        $user = auth()->user();
        if ($course->instructor_id !== $user->id && $user->role?->name !== 'SuperAdmin') {
            abort(403, 'You can only manage exams for your own courses.');
        }
    }
}
