@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Fees Collection</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Fees Collection</a></li>
        </ol>
        <a href="{{ route('admin.fee-management.ledger') }}" class="btn btn-sm btn-primary ms-3">Student Ledger</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
@endif
@if(session('info'))
    <div class="alert alert-info mb-3 rounded">{{ session('info') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger mb-3 rounded">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger mb-3 rounded">{{ $errors->first() }}</div>
@endif

<!-- Quick actions (top) -->
<div class="row mb-4">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Quick actions</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-outline-secondary btn-sm">All Enrollments</a>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary btn-sm">All Invoices</a>
                    <a href="{{ route('admin.invoices.create') }}" class="btn btn-outline-secondary btn-sm">Create invoice</a>
                    <form method="post" action="{{ route('admin.invoices.generate-vouchers') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm">Generate vouchers (current month)</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section A: Quick Stats (KPIs) -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-body small mb-1">Total Revenue (This Month)</h6>
                <h3 class="mb-0 fw-bold text-success">{{ $currency }} {{ number_format($totalRevenueThisMonth, 0) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.fee-management.index', ['enrollment_filter' => 'New']) }}" class="text-decoration-none text-body">
            <div class="card h-100 {{ $pendingApprovalsCount > 0 ? 'border-warning' : '' }}">
                <div class="card-body">
                    <h6 class="text-body small mb-1">Pending Approvals</h6>
                    <h3 class="mb-0 fw-bold">{{ $pendingApprovalsCount }} <span class="small fw-normal">Students</span></h3>
                    <span class="small text-body">Waiting for enrollment acceptance</span>
                </div>
            </div>
        </a>
    </div>
    @if(($pendingPaymentApprovalsCount ?? 0) > 0)
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.invoices.index') }}" class="text-decoration-none text-body">
            <div class="card h-100 border-warning">
                <div class="card-body">
                    <h6 class="text-body small mb-1">Payment Approvals</h6>
                    <h3 class="mb-0 fw-bold">{{ $pendingPaymentApprovalsCount }} <span class="small fw-normal">Pending</span></h3>
                    <span class="small text-body">Payments awaiting approval (apply in invoice)</span>
                </div>
            </div>
        </a>
    </div>
    @endif
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.fee-management.index', ['voucher_filter' => 'Verification Pending']) }}" class="text-decoration-none text-body">
            <div class="card h-100 {{ $unverifiedPaymentsCount > 0 ? 'border-info' : '' }}">
                <div class="card-body">
                    <h6 class="text-body small mb-1">Unverified Payments</h6>
                    <h3 class="mb-0 fw-bold">{{ $unverifiedPaymentsCount }} <span class="small fw-normal">Receipts</span></h3>
                    <span class="small text-body">Uploaded by students, waiting for admin check</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.defaulters.index') }}" class="text-decoration-none text-body">
            <div class="card h-100 {{ $defaultersCount > 0 ? 'border-danger' : '' }}">
                <div class="card-body">
                    <h6 class="text-body small mb-1">Defaulters</h6>
                    <h3 class="mb-0 fw-bold">{{ $defaultersCount }} <span class="small fw-normal">Students</span></h3>
                    <span class="small text-body">Late on payments &gt; 10 days</span>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Section B: Enrollment Requests -->
<div class="row mb-4">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center gap-2">
                <h5 class="card-title mb-0">Enrollment Requests</h5>
                <div class="btn-group btn-group-sm ms-auto">
                    <a href="{{ route('admin.fee-management.index', array_merge(request()->query(), ['enrollment_filter' => 'New'])) }}" class="btn btn-{{ $enrollmentFilter === 'New' ? 'warning' : 'outline-secondary' }}">New</a>
                    <a href="{{ route('admin.fee-management.index', array_merge(request()->query(), ['enrollment_filter' => 'Approved'])) }}" class="btn btn-{{ $enrollmentFilter === 'Approved' ? 'success' : 'outline-secondary' }}">Approved</a>
                    <a href="{{ route('admin.fee-management.index', array_merge(request()->query(), ['enrollment_filter' => 'Rejected'])) }}" class="btn btn-{{ $enrollmentFilter === 'Rejected' ? 'danger' : 'outline-secondary' }}">Rejected</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Course</th>
                                <th scope="col">Request Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrollments as $e)
                            <tr>
                                <th>{{ $loop->iteration + ($enrollments->currentPage() - 1) * $enrollments->perPage() }}</th>
                                <td>{{ $e->user->name ?? $e->user->email }}</td>
                                <td>{{ $e->course?->name ?? '—' }} @if($e->batch)({{ $e->batch->name }})@endif</td>
                                <td>{{ $e->created_at?->format('M d, Y') }}</td>
                                <td>
                            @if($e->enrollment_status === 'pending_approval')
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal" data-enrollment-id="{{ $e->id }}" data-student-name="{{ $e->user->name ?? $e->user->email }}">Approve</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal" data-enrollment-id="{{ $e->id }}" data-student-name="{{ $e->user->name ?? $e->user->email }}">Reject</button>
                            @elseif($e->enrollment_status === 'active')
                                <button type="button" class="btn btn-sm btn-outline-primary btn-transfer" data-bs-toggle="modal" data-bs-target="#transferModal" data-enrollment-id="{{ $e->id }}" data-course-name="{{ $e->course?->name ?? '—' }}" data-batch-name="{{ $e->batch?->name ?? '—' }}" data-batch-id="{{ $e->batch_id ?? '' }}" data-fee="{{ number_format($e->monthly_fee ?? $e->batch?->monthly_fee ?? 0, 0) }}" data-redirect="fee-management" onclick="document.getElementById('transfer_enrollment_id').value='{{ $e->id }}';document.getElementById('transfer_redirect').value='fee-management';">
                                    Transfer / Change Course
                                </button>
                                @if(auth()->user()->role?->name === 'SuperAdmin')
                                    <form action="{{ route('admin.fee-management.manual-access', $e) }}" method="post" class="d-inline ms-1">
                                        @csrf
                                        @if($e->manual_access)
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Revoke free access; student will need to pay to unlock">Revoke manual access</button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Unlock portal without fee payment">Grant manual access (free)</button>
                                        @endif
                                    </form>
                                @endif
                                @if($e->manual_access)
                                    <span class="badge badge-rounded badge-info ms-1" title="Portal access granted without fee">Free access</span>
                                @endif
                                <span class="badge badge-rounded badge-success ms-1">{{ $e->enrollment_status }}</span>
                            @else
                                <span class="badge badge-rounded badge-{{ $e->enrollment_status === 'rejected' ? 'danger' : 'secondary' }}">{{ $e->enrollment_status }}</span>
                            @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No enrollments in this filter.</td></tr>
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

<!-- Approve modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="approveForm" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Approve enrollment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Approve enrollment for <strong id="approveStudentName"></strong>?</p>
                    <div class="mb-3">
                        <label class="form-label">Apply permanent scholarship (optional)</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <select name="discount_type" id="approveDiscountType" class="form-select form-select-sm">
                                    <option value="None">None</option>
                                    <option value="Percentage">Percentage off</option>
                                    <option value="Fixed">Flat amount off</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="number" name="discount_value" id="approveDiscountValue" class="form-control form-control-sm" min="0" step="0.01" placeholder="e.g. 10 or 500" style="display:none;">
                            </div>
                        </div>
                        <small class="text-body-secondary">e.g. 10% off or 500 flat. Applied to every future voucher.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve & create Voucher #1</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject modal: rejection reason is sent to the student and shown in their dashboard / email -->
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
                    <label class="form-label">Rejection reason <span class="text-body-secondary">(e.g. Missing CNIC copy, Ineligible for NAVTTC — shown to student and in email)</span></label>
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

<!-- Section C: Fee Vouchers -->
<div class="row mb-4">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center gap-2">
                <h5 class="card-title mb-0">Fee Vouchers</h5>
                <div class="btn-group btn-group-sm ms-auto">
                    <a href="{{ route('admin.fee-management.index', array_merge(request()->query(), ['voucher_filter' => 'Unpaid'])) }}" class="btn btn-{{ $voucherFilter === 'Unpaid' ? 'warning' : 'outline-secondary' }}">Unpaid</a>
                    <a href="{{ route('admin.fee-management.index', array_merge(request()->query(), ['voucher_filter' => 'Verification Pending'])) }}" class="btn btn-{{ $voucherFilter === 'Verification Pending' ? 'info' : 'outline-secondary' }}">Verification Pending</a>
                    <a href="{{ route('admin.fee-management.index', array_merge(request()->query(), ['voucher_filter' => 'Paid'])) }}" class="btn btn-{{ $voucherFilter === 'Paid' ? 'success' : 'outline-secondary' }}">Paid</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Voucher ID</th>
                                <th scope="col">Student</th>
                                <th scope="col">Month</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vouchers as $v)
                            <tr>
                                <th>{{ $loop->iteration + ($vouchers->currentPage() - 1) * $vouchers->perPage() }}</th>
                                <td>#{{ $v->invoice_no }}</td>
                                <td>{{ $v->user->name ?? $v->user->email }}</td>
                                <td>{{ $v->billing_month ? $v->billing_month->format('M Y') : '—' }}</td>
                                <td>{{ $currency }} {{ number_format($v->amount, 0) }}</td>
                                <td>{{ number_format($v->discount_amount ?? 0, 0) }}</td>
                                <td>
                                    @if($v->amount_paid >= $v->amount_after_discount)
                                        <span class="badge badge-rounded badge-success">Paid</span>
                                    @elseif($v->proof_image_path)
                                        <span class="badge badge-rounded badge-info">Verification Pending</span>
                                    @elseif($v->status === 'overdue')
                                        <span class="badge badge-rounded badge-danger">Overdue</span>
                                    @else
                                        <span class="badge badge-rounded badge-warning">Unpaid</span>
                                    @endif
                                </td>
                                <td>
                            @if($v->proof_image_path)
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#receiptModal" data-receipt-url="{{ asset('storage/' . $v->proof_image_path) }}">View Receipt</button>
                            @endif
                            <a href="{{ route('admin.invoices.show', $v) }}" class="btn btn-sm btn-outline-secondary">{{ $v->proof_image_path ? 'Verify' : 'Record payment' }}</a>
                            @if($v->balance > 0 && !$v->proof_image_path)
                                <form action="{{ route('admin.invoices.remind', $v) }}" method="post" class="d-inline" onsubmit="return confirm('Send fee reminder to {{ $v->user->name ?? 'student' }}?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Send SMS/reminder: Your fee for {{ $v->billing_month?->format('F Y') }} is pending.">Remind</button>
                                </form>
                            @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">No vouchers in this filter.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($vouchers->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $vouchers->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Receipt modal -->
<div class="modal fade" id="receiptModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Uploaded receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="receiptImage" src="" alt="Receipt" class="img-fluid rounded" style="max-height:70vh;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var approveModal = document.getElementById('approveModal');
    if (approveModal) {
        approveModal.addEventListener('show.bs.modal', function(e) {
            var btn = e.relatedTarget;
            var id = btn.getAttribute('data-enrollment-id');
            var name = btn.getAttribute('data-student-name');
            document.getElementById('approveStudentName').textContent = name || 'Student';
            document.getElementById('approveForm').action = '{{ url("admin/enrollments") }}/' + id + '/approve';
        });
    }
    var rejectModal = document.getElementById('rejectModal');
    if (rejectModal) {
        rejectModal.addEventListener('show.bs.modal', function(e) {
            var btn = e.relatedTarget;
            var id = btn ? btn.getAttribute('data-enrollment-id') : '';
            var name = btn ? btn.getAttribute('data-student-name') : '';
            document.getElementById('rejectStudentName').textContent = name || 'Student';
            document.getElementById('rejectForm').action = '{{ url("admin/enrollments") }}/' + id + '/reject';
            document.getElementById('rejectReason').value = '';
        });
    }
    var discountType = document.getElementById('approveDiscountType');
    var discountValue = document.getElementById('approveDiscountValue');
    if (discountType) {
        discountType.addEventListener('change', function() {
            discountValue.style.display = (this.value === 'None') ? 'none' : 'block';
        });
    }
    var receiptModal = document.getElementById('receiptModal');
    if (receiptModal) {
        receiptModal.addEventListener('show.bs.modal', function(e) {
            var url = e.relatedTarget ? e.relatedTarget.getAttribute('data-receipt-url') : '';
            document.getElementById('receiptImage').src = url || '';
        });
    }
    var transferModal = document.getElementById('transferModal');
    if (transferModal) {
        transferModal.addEventListener('show.bs.modal', function(e) {
            var btn = e.relatedTarget || document.querySelector('.btn-transfer');
            if (btn) {
                var id = btn.getAttribute('data-enrollment-id');
                var course = btn.getAttribute('data-course-name') || '—';
                var batch = btn.getAttribute('data-batch-name') || '';
                var fee = btn.getAttribute('data-fee') || '0';
                var batchId = btn.getAttribute('data-batch-id') || '';
                document.getElementById('transfer_enrollment_id').value = id || '';
                document.getElementById('transferCurrentInfo').textContent = course + (batch ? ' (' + batch + ')') + ' — Fee: {{ $currency }} ' + fee + '/mo';
                var hidden = document.getElementById('transfer_redirect');
                if (hidden) { hidden.value = btn.getAttribute('data-redirect') || ''; }
                var sel = document.getElementById('transfer_new_batch_id');
                sel.value = '';
                [].forEach.call(sel.options, function(opt) {
                    opt.disabled = (opt.value && opt.value === batchId);
                });
            }
        });
    }
});
</script>
@endsection
