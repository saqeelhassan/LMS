@extends('layouts.student')

@section('content')
<div>
    <div class="mb-4 no-print">
        <h1 class="h3 mb-1">Digital ID Card</h1>
        <p class="mb-0">DSIMT Student ID — view, download, or print.</p>
    </div>

    {{-- ID card: same layout on screen and when printing / saving as PDF --}}
    <div class="id-card-print-area">
    <div class="id-card-wrapper mb-4">
        <div class="id-card shadow-sm" id="id-card">
            <div class="id-card-header">
                <img src="{{ asset('images/logo.png') }}" alt="DSIMT" class="id-card-header-logo">
                <span class="id-card-badge">Student ID</span>
            </div>
            <div class="id-card-body">
                <div class="id-card-photo">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="Student Photo" class="id-card-photo-img" crossorigin="anonymous">
                    @else
                        <div class="id-card-photo-placeholder">
                            <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        </div>
                    @endif
                </div>
                <div class="id-card-details">
                    <div class="id-card-name">{{ $user->name }}</div>
                    <div class="id-card-id">ID: DSIMT-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                    @if($primaryEnrollment)
                        <div class="id-card-course">{{ $primaryEnrollment->course->name }}</div>
                        @if($primaryEnrollment->batch)
                            <div class="id-card-batch">Batch: {{ $primaryEnrollment->batch->name }}</div>
                        @endif
                    @elseif($enrollments->isNotEmpty())
                        <div class="id-card-course">Courses: {{ $enrollments->pluck('course.name')->take(2)->join(', ') }}{{ $enrollments->count() > 2 ? '…' : '' }}</div>
                    @endif
                    <div class="id-card-contact">
                        <span>{{ $user->email }}</span>
                        @if($user->userDetail && $user->userDetail->mobile)
                            <span class="id-card-sep">·</span>
                            <span>{{ $user->userDetail->mobile }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="id-card-footer">
                <span>Valid for academic use</span>
            </div>
        </div>
    </div>
    </div>

    <div class="no-print d-flex flex-wrap gap-2 align-items-center">
        <button type="button" onclick="window.print();" class="btn btn-primary">
            <i class="bi bi-printer me-1"></i>Print / Save as PDF
        </button>
        <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
        <span class="text-muted small align-self-center ms-2">Use "Save as PDF" in the print dialog to get a PDF with the same layout.</span>
    </div>
</div>

<style>
.id-card-wrapper {
    max-width: 400px;
}
.id-card {
    --id-header: #0d6efd;
    --id-header-text: #fff;
    --id-border: #dee2e6;
    background: #fff;
    border: 1px solid var(--id-border);
    border-radius: 12px;
    overflow: hidden;
    font-family: system-ui, -apple-system, sans-serif;
}
.id-card-header {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    color: var(--id-header-text);
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.id-card-header-logo {
    height: 32px;
    width: auto;
    max-width: 140px;
    object-fit: contain;
    flex-shrink: 0;
}
.id-card-badge {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    background: rgba(255,255,255,0.25);
    padding: 2px 8px;
    border-radius: 4px;
    margin-left: auto;
}
.id-card-body {
    display: flex;
    gap: 14px;
    padding: 14px;
    align-items: flex-start;
}
.id-card-photo {
    flex-shrink: 0;
}
.id-card-photo-img,
.id-card-photo-placeholder {
    width: 72px;
    height: 72px;
    border-radius: 8px;
    border: 2px solid var(--id-border);
    object-fit: cover;
}
.id-card-photo-placeholder {
    background: linear-gradient(145deg, #e9ecef 0%, #dee2e6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
    color: #495057;
}
.id-card-details {
    flex: 1;
    min-width: 0;
}
.id-card-name {
    font-weight: 700;
    font-size: 1rem;
    line-height: 1.2;
    margin-bottom: 2px;
    color: #212529;
}
.id-card-id {
    font-size: 0.7rem;
    color: #6c757d;
    margin-bottom: 4px;
}
.id-card-course {
    font-size: 0.75rem;
    font-weight: 600;
    color: #0a58ca;
    margin-bottom: 2px;
}
.id-card-batch {
    font-size: 0.7rem;
    color: #495057;
    margin-bottom: 4px;
}
.id-card-contact {
    font-size: 0.65rem;
    color: #6c757d;
}
.id-card-sep {
    margin: 0 4px;
    opacity: 0.7;
}
.id-card-footer {
    padding: 6px 14px;
    background: #f8f9fa;
    border-top: 1px solid var(--id-border);
    font-size: 0.65rem;
    color: #6c757d;
}
</style>

<style media="print">
/* Single page: hide everything except the ID card */
.no-print, nav, .navbar, .sidebar, .btn, .breadcrumb, .back-top, footer, .view-as-banner { display: none !important; }
/* Hide page banner and topbar so they don't create page 1 */
section:first-of-type { display: none !important; }
body, main, .container, .container-fluid, .row { background: #fff !important; margin: 0 !important; padding: 0 !important; border: none !important; }
section .container .row { display: flex !important; justify-content: center !important; }
.col-xl-3 { display: none !important; }
.col-xl-9 { max-width: 100% !important; flex: 0 0 100% !important; }
/* No min-height: card only, one page */
.id-card-print-area { display: flex !important; justify-content: center !important; align-items: center !important; width: 100% !important; margin: 0 !important; padding: 0 !important; min-height: 0 !important; }
.id-card-wrapper { max-width: 400px !important; width: 100% !important; margin: 0 !important; }
.id-card { box-shadow: none !important; border: 1px solid #333 !important; margin: 0 !important; width: 100% !important; break-inside: avoid !important; page-break-inside: avoid !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
.id-card-header { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
.id-card-photo-img, .id-card-header-logo { visibility: visible !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
@page { size: auto; margin: 15mm; }
</style>
@endsection
