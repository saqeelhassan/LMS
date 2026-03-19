<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\DigiSindhAdminController;
use App\Http\Controllers\Traits\UsesEnrollmentFeeLogic;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Enrollment;
use App\Notifications\EnrollmentRejectedNotification;
use App\Services\EnrollmentTransferService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnrollmentController extends DigiSindhAdminController
{
    use UsesEnrollmentFeeLogic;
    /**
     * Display a listing of enrollments for the admin dashboard.
     */
    public function index(Request $request): View
    {
        $enrollments = Enrollment::with(['user.userDetail', 'course', 'batch'])
            ->when($request->filled('course'), fn ($q) => $q->where('course_id', $request->course))
            ->when($request->filled('status'), fn ($q) => $q->where('enrollment_status', $request->status))
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        $courses = Course::orderBy('name')->get();
        $batchesForTransfer = Batch::with('course')->where('is_active', true)->orderBy('course_id')->get()->groupBy('course_id');

        return view('admin.enrollments.index', compact('enrollments', 'courses', 'batchesForTransfer'));
    }

    /**
     * Approve a pending enrollment: optional permanent discount, set active, generate Month 1 voucher.
     * Custom logic lives in UsesEnrollmentFeeLogic trait (Digi Sindh).
     */
    public function approve(Request $request, Enrollment $enrollment): RedirectResponse
    {
        if ($enrollment->enrollment_status !== 'pending_approval') {
            return redirect()->back()->with('info', 'Enrollment is not pending approval.');
        }

        $result = $this->applyEnrollmentApprovalLogic($enrollment, $request);

        return redirect()->back()->with('success', $result['message']);
    }

    /**
     * Reject a pending enrollment. Saves rejection reason and notifies the student
     * (database notification + email with re-apply link).
     */
    public function reject(Request $request, Enrollment $enrollment): RedirectResponse
    {
        if ($enrollment->enrollment_status !== 'pending_approval') {
            return redirect()->back()->with('info', 'Enrollment is not pending approval.');
        }

        $validated = $request->validate([
            'rejection_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $enrollment->update([
            'enrollment_status' => 'rejected',
            'rejection_note' => $validated['rejection_note'] ?? null,
            'is_eligible_for_reapplication' => true,
        ]);

        $enrollment->user?->notify(new EnrollmentRejectedNotification($enrollment));

        return redirect()->back()->with('success', 'Enrollment rejected. The student has been notified.');
    }

    /**
     * Process course/batch transfer.
     */
    public function transfer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'enrollment_id' => ['required', 'integer', 'exists:enrollments,id'],
            'new_batch_id' => ['required', 'integer', 'exists:batches,id'],
            'effective_date' => ['required', 'in:immediately,next_month'],
        ]);

        $enrollment = Enrollment::findOrFail($validated['enrollment_id']);

        if ($enrollment->enrollment_status !== 'active') {
            return redirect()->back()->with('info', 'Only active enrollments can be transferred.');
        }

        try {
            $service = app(EnrollmentTransferService::class);
            $result = $service->transfer(
                $enrollment,
                (int) $validated['new_batch_id'],
                $validated['effective_date']
            );

            if (! $result['success']) {
                return redirect()->back()->with('error', $result['message'])->withInput();
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Transfer failed: ' . $e->getMessage())->withInput();
        }

        $redirectTo = $request->get('redirect') === 'enrollments' ? route('admin.enrollments.index') : route('admin.fee-management.index');

        return redirect($redirectTo)->with('success', $result['message']);
    }
}
