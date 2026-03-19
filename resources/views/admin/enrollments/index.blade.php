@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Enrollments</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Enrollments</a></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Enrollments</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mb-3 rounded">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-3 rounded">{{ $errors->first() }}</div>
                @endif

                <form method="get" action="{{ route('admin.enrollments.index') }}" class="row g-2 align-items-end mb-4">
                    <div class="col-md-3">
                        <label class="form-label small mb-0">Course</label>
                        <select name="course" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All Courses</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ request('course') == $c->id ? 'selected' : '' }}>{{ Str::limit($c->name, 40) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small mb-0">Status</label>
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="pending_approval" {{ request('status') === 'pending_approval' ? 'selected' : '' }}>Pending approval</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="dropped" {{ request('status') === 'dropped' ? 'selected' : '' }}>Dropped</option>
                        </select>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Student</th>
                                <th scope="col">Course</th>
                                <th scope="col">Batch</th>
                                <th scope="col">Status</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Enrolled</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrollments as $enrollment)
                                <tr>
                                    <th>{{ $loop->iteration + ($enrollments->currentPage() - 1) * $enrollments->perPage() }}</th>
                                    <td>{{ $enrollment->user->name ?? $enrollment->user->email }}</td>
                                    <td>{{ $enrollment->course?->name ?? '—' }}</td>
                                    <td>{{ $enrollment->batch?->name ?? '—' }}</td>
                                    <td>
                                        @if(($enrollment->enrollment_status ?? '') === 'pending_approval')
                                            <span class="badge badge-rounded badge-warning">Pending</span>
                                        @elseif(($enrollment->enrollment_status ?? '') === 'active')
                                            <span class="badge badge-rounded badge-success">Active</span>
                                        @elseif(($enrollment->enrollment_status ?? '') === 'rejected')
                                            <span class="badge badge-rounded badge-danger">Rejected</span>
                                        @elseif(($enrollment->enrollment_status ?? '') === 'dropped')
                                            <span class="badge badge-rounded badge-secondary">Dropped</span>
                                        @else
                                            <span class="badge badge-light text-dark">{{ $enrollment->enrollment_status ?? '—' }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $enrollment->payment_status ?? '—' }}</td>
                                    <td>{{ $enrollment->created_at?->format('M j, Y') ?? '—' }}</td>
                                    <td>
                                        @if(($enrollment->enrollment_status ?? '') === 'pending_approval')
                                            <form method="post" action="{{ route('admin.enrollments.approve', $enrollment) }}" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-success">Approve</button></form>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal" data-enrollment-id="{{ $enrollment->id }}" data-student-name="{{ $enrollment->user->name ?? $enrollment->user->email }}">Reject</button>
                                        @elseif(($enrollment->enrollment_status ?? '') === 'active')
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-transfer" data-bs-toggle="modal" data-bs-target="#transferModal" data-enrollment-id="{{ $enrollment->id }}" data-course-name="{{ $enrollment->course?->name ?? '—' }}" data-batch-name="{{ $enrollment->batch?->name ?? '—' }}" data-batch-id="{{ $enrollment->batch_id ?? '' }}" data-fee="{{ number_format($enrollment->monthly_fee ?? $enrollment->batch?->monthly_fee ?? 0, 0) }}" data-redirect="enrollments" onclick="document.getElementById('transfer_enrollment_id').value='{{ $enrollment->id }}';document.getElementById('transfer_redirect').value='enrollments';">
                                                Transfer / Change Course
                                            </button>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted py-4">No enrollments yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($enrollments->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $enrollments->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="rejectForm" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject enrollment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Reject application for <strong id="rejectStudentName"></strong>?</p>
                    <label class="form-label">Rejection reason <span class="text-body-secondary">(e.g. Missing CNIC copy, Ineligible — shown to student and in email)</span></label>
                    <textarea name="rejection_note" id="rejectReason" class="form-control" rows="3" placeholder="Optional reason for rejection"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject & notify student</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.enrollments.partials.transfer-modal')

<script>
document.addEventListener('DOMContentLoaded', function() {
    var rejectModal = document.getElementById('rejectModal');
    if (rejectModal) {
        rejectModal.addEventListener('show.bs.modal', function(e) {
            var btn = e.relatedTarget;
            var id = btn ? btn.getAttribute('data-enrollment-id') : '';
            var name = btn ? btn.getAttribute('data-student-name') : '';
            document.getElementById('rejectStudentName').textContent = name || 'Student';
            document.getElementById('rejectForm').action = '{{ url("admin/enrollments") }}/' + id + '/reject';
            var reasonEl = document.getElementById('rejectReason');
            if (reasonEl) { reasonEl.value = ''; }
        });
    }
    var transferModal = document.getElementById('transferModal');
    if (transferModal) {
        transferModal.addEventListener('show.bs.modal', function(e) {
            var btn = e.relatedTarget;
            if (btn) {
                var id = btn.getAttribute('data-enrollment-id');
                var actionUrl = btn.getAttribute('data-transfer-url');
                var course = btn.getAttribute('data-course-name') || '—';
                var batch = btn.getAttribute('data-batch-name') || '';
                var fee = btn.getAttribute('data-fee') || '0';
                var redirect = btn.getAttribute('data-redirect') || '';
                var batchId = btn.getAttribute('data-batch-id') || '';
                var currency = '{{ \App\Models\Setting::get("currency", "PKR") }}';
                document.getElementById('transferCurrentInfo').textContent = course + (batch ? ' (' + batch + ')') + ' — Fee: ' + currency + ' ' + fee + '/mo';
                document.getElementById('transferForm').action = actionUrl || ('{{ url("admin/enrollments") }}/' + id + '/transfer');
                var hidden = document.getElementById('transfer_redirect');
                if (hidden) { hidden.value = redirect; }
                var sel = document.getElementById('transfer_new_batch_id');
                if (sel) {
                    sel.value = '';
                    [].forEach.call(sel.options, function(opt) {
                        opt.disabled = (opt.value && opt.value === batchId);
                    });
                }
            }
        });
    }
});
</script>
@endsection
