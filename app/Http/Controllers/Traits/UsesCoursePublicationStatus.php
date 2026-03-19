<?php

namespace App\Http\Controllers\Traits;

use App\Models\Course;

/**
 * Trait for controllers that manage course publication_status (draft → pending → approved).
 * Keeps Digi Sindh website approval workflow isolated from core LMS.
 */
trait UsesCoursePublicationStatus
{
    protected function setCourseDraft(Course $course): void
    {
        $course->update(['publication_status' => Course::PUBLICATION_DRAFT]);
    }

    protected function setCoursePendingApproval(Course $course): void
    {
        $course->update(['publication_status' => Course::PUBLICATION_PENDING]);
    }
}
