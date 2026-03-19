{{-- Start of Biometric Sync Section - uFace 800 only. Sync, Export, Payroll. --}}
@props(['date' => now()->toDateString()])

<div class="mb-4 d-flex flex-wrap align-items-center gap-2 biometric-action-bar">
    <form method="post" action="{{ route('admin.attendance.sync-zkteco') }}" class="d-inline" id="form-sync-zkteco" data-dsimt-form data-loading-target="btn-sync-zkteco">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        <button type="submit" class="btn btn-primary btn-dsimt" id="btn-sync-zkteco">
            <span class="btn-sync-text"><i class="bi bi-fingerprint me-1" aria-hidden="true"></i>Sync Now with uFace 800</span>
            <span class="spinner-border spinner-border-sm d-none ms-1" role="status" aria-hidden="true"></span>
        </button>
    </form>
    <div class="btn-group btn-group-sm ms-2" role="group">
        <a href="{{ route('admin.attendance.export-pdf', ['date' => $date]) }}" class="btn btn-outline-danger btn-dsimt" target="_blank" rel="noopener">
            <i class="bi bi-file-pdf me-1" aria-hidden="true"></i>Export PDF
        </a>
        <a href="{{ route('admin.attendance.export-excel', ['date' => $date]) }}" class="btn btn-outline-success btn-dsimt">
            <i class="bi bi-file-excel me-1" aria-hidden="true"></i>Export Excel
        </a>
    </div>
    <form method="get" action="{{ route('admin.attendance.payroll-csv') }}" class="d-inline-flex gap-2 align-items-center ms-2">
        <input type="month" name="month" value="{{ \Carbon\Carbon::parse($date)->format('Y-m') }}" class="form-control form-control-sm payroll-month-input">
        <button type="submit" class="btn btn-success btn-sm btn-dsimt">
            <i class="bi bi-download me-1" aria-hidden="true"></i>Payroll CSV
        </button>
    </form>
    <a href="{{ route('admin.attendance.government-report', ['program' => 'BBSHRRDA']) }}" class="btn btn-outline-primary btn-sm btn-dsimt ms-2">
        <i class="bi bi-file-earmark-text me-1" aria-hidden="true"></i>Generate BBSHRRDA Monthly Report
    </a>
</div>
