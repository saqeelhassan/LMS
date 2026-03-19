<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Invoice;
use App\Services\FeeVoucherService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Mark a single notification as read (for bell dropdown). Only the owner can mark.
     */
    public function markNotificationRead(string $id): JsonResponse
    {
        $notification = auth()->user()->unreadNotifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['ok' => true]);
    }
    public function idCard(): View
    {
        $user = auth()->user();
        $user->load('userDetail', 'role');
        $enrollments = $user->enrollments()->with(['course', 'batch'])->where('enrollment_status', 'active')->latest()->get();
        $primaryEnrollment = $enrollments->first();

        return view('student.profile.id-card', compact('user', 'enrollments', 'primaryEnrollment'));
    }

    public function feeStatus(): View
    {
        $user = auth()->user();

        // Automatically generate monthly fee vouchers for current month (and last month if missing)
        // so the student always sees their vouchers when they open Fee Status.
        $voucherService = app(FeeVoucherService::class);
        $voucherService->generateForMonth(Carbon::now()->startOfMonth());
        $voucherService->generateForMonth(Carbon::now()->subMonth()->startOfMonth());

        $invoices = Invoice::where('user_id', $user->id)
            ->with('enrollment.course')
            ->latest()
            ->paginate(15);

        $pendingCount = Invoice::where('user_id', $user->id)
            ->whereRaw('(amount - COALESCE(discount_amount,0) - amount_paid) > 0')
            ->count();

        return view('student.profile.fee-status', compact('invoices', 'pendingCount'));
    }

    /**
     * Upload payment receipt for an invoice (student's own invoice only).
     */
    public function uploadReceipt(Request $request, Invoice $invoice): RedirectResponse
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'This invoice does not belong to you.');
        }
        if ($invoice->balance <= 0) {
            return redirect()->route('student.fee-status')->with('info', 'This voucher is already paid.');
        }

        $request->validate([
            'receipt' => ['required', 'file', 'image', 'max:5120'], // 5MB
        ]);

        $file = $request->file('receipt');
        $dir = 'receipts/' . now()->format('Y/m');
        $path = $file->store($dir, 'public');

        // Remove old receipt file if any
        if ($invoice->proof_image_path && Storage::disk('public')->exists($invoice->proof_image_path)) {
            Storage::disk('public')->delete($invoice->proof_image_path);
        }

        $invoice->update(['proof_image_path' => $path]);

        return redirect()->route('student.fee-status')->with('success', 'Receipt uploaded. Admin will verify and update your payment.');
    }

    public function certificates(): View
    {
        $user = auth()->user();
        $enrollments = $user->enrollments()
            ->whereNotNull('completed_at')
            ->with('course')
            ->latest()
            ->get();

        return view('student.profile.certificates', compact('enrollments'));
    }

    public function certificateShow(Enrollment $enrollment): View|\Illuminate\Http\RedirectResponse
    {
        if ($enrollment->user_id !== auth()->id()) {
            abort(403);
        }
        if (! $enrollment->completed_at) {
            abort(404, 'Certificate not available.');
        }
        $enrollment->load('course', 'user.userDetail');

        return view('student.profile.certificate-view', compact('enrollment'));
    }
}
