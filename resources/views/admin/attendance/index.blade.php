@extends('layouts.admin')

@section('css')
<link href="{{ asset('css/custom-dsimt.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Attendance & Payroll</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Attendance & Payroll</a></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Biometric Attendance</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mb-3 rounded">{{ session('error') }}</div>
                @endif

                <form method="get" action="{{ route('admin.attendance.index') }}" class="row g-2 align-items-end mb-4">
                    <div class="col-auto">
                        <label for="date" class="form-label small mb-0">Date</label>
                        <input type="date" name="date" id="date" class="form-control form-control-sm" value="{{ $date }}" aria-label="Select date">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm">Show</button>
                    </div>
                </form>

                <div class="mb-3 d-flex align-items-center gap-2 flex-wrap">
                    <span class="text-body-secondary small">Scanner:</span>
                    @switch($scannerStatus ?? '')
                        @case('connected')
                            <span class="badge badge-rounded badge-success" aria-live="polite">Connected</span>
                            @break
                        @case('disconnected')
                            <span class="badge badge-rounded badge-danger" aria-live="polite">Disconnected</span>
                            @break
                        @default
                            <span class="badge badge-rounded badge-secondary" aria-live="polite">— Sync to check</span>
                    @endswitch
                </div>

                @include('admin.attendance.partials.biometric-sync-buttons', ['date' => $date])

                @include('admin.attendance.partials.attendance-table')
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('form-sync-zkteco');
    if (!form) return;
    var btn = document.getElementById('btn-sync-zkteco');
    var text = btn && btn.querySelector('.btn-sync-text');
    var spinner = btn && btn.querySelector('.spinner-border');
    form.addEventListener('submit', function() {
        if (btn) btn.setAttribute('aria-busy', 'true');
        if (text) text.classList.add('d-none');
        if (spinner) spinner.classList.remove('d-none');
    });
});
</script>
@endsection
