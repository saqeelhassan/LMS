@extends('layouts.student')

@section('content')
<div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show"><span>{{ session('success') }}</span><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show"><span>{{ session('info') }}</span><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    <div class="mb-4">
        <h1 class="h3 mb-1">Fee Status</h1>
        <p class="mb-0">You receive a <strong>monthly fee voucher</strong> for each enrolled course. Pay each voucher by the due date to continue your classes.</p>
    </div>

    @if($pendingCount > 0)
        <div class="alert alert-warning alert-dismissible fade show">
            You have <strong>{{ $pendingCount }}</strong> unpaid voucher(s). Please pay to continue your classes.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Voucher / Invoice</th>
                            <th>Month</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due date</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $inv)
                        <tr>
                            <td>{{ $inv->invoice_no }}</td>
                            <td>{{ $inv->billing_month ? $inv->billing_month->format('M Y') : '—' }}</td>
                            <td>{{ $inv->enrollment->course->name ?? '—' }}</td>
                            <td>{{ number_format($inv->amount, 2) }}</td>
                            <td>{{ number_format($inv->amount_paid, 2) }}</td>
                            <td>{{ $inv->due_date?->format('M d, Y') ?? '—' }}</td>
                            <td>
                                @if($inv->amount_paid >= $inv->amount_after_discount)
                                    <span class="badge bg-success">Paid</span>
                                @elseif($inv->proof_image_path)
                                    <span class="badge bg-secondary">Verification pending</span>
                                @elseif($inv->status === 'overdue')
                                    <span class="badge bg-danger">Overdue</span>
                                @elseif($inv->amount_paid > 0)
                                    <span class="badge bg-info">Partial</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($inv->balance > 0)
                                    @if($inv->proof_image_path)
                                        <span class="text-muted small">Receipt uploaded</span>
                                    @else
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadReceiptModal" data-invoice-id="{{ $inv->id }}" data-invoice-no="{{ $inv->invoice_no }}">
                                            <i class="bi bi-upload me-1"></i>Upload receipt
                                        </button>
                                    @endif
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No fee vouchers yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($invoices->hasPages())
                <div class="d-flex justify-content-center mt-3">{{ $invoices->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Upload receipt modal -->
    <div class="modal fade" id="uploadReceiptModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" enctype="multipart/form-data" id="uploadReceiptForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Upload payment receipt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">Voucher: <strong id="uploadInvoiceNo"></strong></p>
                        <p class="small mb-3">Upload a clear image of your payment receipt (screenshot or photo). Max 5MB. Formats: JPG, PNG, GIF, WebP.</p>
                        <input type="file" name="receipt" class="form-control" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('uploadReceiptModal');
    if (modal) {
        modal.addEventListener('show.bs.modal', function(e) {
            var btn = e.relatedTarget;
            if (btn) {
                var id = btn.getAttribute('data-invoice-id');
                var no = btn.getAttribute('data-invoice-no');
                document.getElementById('uploadInvoiceNo').textContent = no || '';
                document.getElementById('uploadReceiptForm').action = '{{ url("student/invoices") }}/' + id + '/upload-receipt';
            }
        });
    }
});
</script>
@endsection
