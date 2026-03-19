<?php

namespace App\Notifications;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Sent when an admin rejects a student's enrollment.
 * Delivered via database (bell icon) and email (Blade template with rejection reason and re-apply link).
 * To queue this notification, add: implements ShouldQueue
 */
class EnrollmentRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Enrollment $enrollment
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /** For the bell icon / in-app notification. */
    public function toArray(object $notifiable): array
    {
        $courseName = $this->enrollment->course?->name ?? 'Course';
        $reason = $this->enrollment->rejection_note
            ? ' — ' . \Illuminate\Support\Str::limit($this->enrollment->rejection_note, 80)
            : '';

        return [
            'type' => 'enrollment_rejected',
            'message' => 'Your application for "' . $courseName . '" was not approved.' . $reason,
            'enrollment_id' => $this->enrollment->id,
            'reapply_url' => route('enrollments.reapply', $this->enrollment),
        ];
    }

    /** For the email (uses Blade template so you can edit the text easily on the server). */
    public function toMail(object $notifiable): MailMessage
    {
        $courseName = $this->enrollment->course?->name ?? 'Course';
        $reapplyUrl = route('enrollments.reapply', $this->enrollment);

        return (new MailMessage)
            ->subject(__('Enrollment application not approved – :course', ['course' => $courseName]))
            ->view('emails.enrollment-rejected', [
                'notifiable' => $notifiable,
                'enrollment' => $this->enrollment,
                'courseName' => $courseName,
                'rejectionReason' => $this->enrollment->rejection_note ?? __('No reason provided.'),
                'reapplyUrl' => $reapplyUrl,
            ]);
    }
}
