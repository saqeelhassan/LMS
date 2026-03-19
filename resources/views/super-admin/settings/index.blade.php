@extends('layouts.super-admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Global Settings</h1>
        <p class="mb-0 text-body">Academic year, currency, institute name, and logo.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
    <div class="card-body p-4">
        <form method="post" action="{{ route('super-admin.settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="academic_year" class="form-label">Academic Year</label>
                    <input type="text" name="academic_year" id="academic_year" class="form-control" value="{{ \App\Models\Setting::get('academic_year') }}" placeholder="e.g. 2024-2025">
                </div>
                <div class="col-md-6">
                    <label for="currency" class="form-label">Currency</label>
                    <input type="text" name="currency" id="currency" class="form-control" value="{{ \App\Models\Setting::get('currency', 'PKR') }}" maxlength="10">
                </div>
                <div class="col-12">
                    <label for="institute_name" class="form-label">Institute Name</label>
                    <input type="text" name="institute_name" id="institute_name" class="form-control" value="{{ \App\Models\Setting::get('institute_name') }}" maxlength="255" placeholder="e.g. Digital Sindh Institute">
                </div>
                <div class="col-12">
                    <label for="logo" class="form-label">Logo</label>
                    @php $logoPath = \App\Models\Setting::get('logo'); @endphp
                    @if($logoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath))
                        <div class="mb-2"><img src="{{ asset('storage/' . $logoPath) }}" alt="Logo" style="max-height:60px;"></div>
                    @else
                        <p class="small text-body-secondary mb-1">Upload a logo to show in the LMS Admin and Super Admin sidebar. If none is set, the default logo is used.</p>
                    @endif
                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                </div>
                <div class="col-12">
                    <label for="attendance_allowed_ips" class="form-label">Instructor check-in allowed IPs (geo-fencing)</label>
                    <input type="text" name="attendance_allowed_ips" id="attendance_allowed_ips" class="form-control" value="{{ \App\Models\Setting::get('attendance_allowed_ips') }}" placeholder="e.g. 192.168.1.1, 10.0.0.0/24 or leave empty to allow any IP">
                    <small class="text-body-secondary">Comma-separated IPs or CIDR. Empty = allow any IP (no restriction).</small>
                </div>
                <div class="col-12 border-top pt-3 mt-2">
                    <h6 class="mb-2">Fee Management</h6>
                    <p class="small text-body-secondary mb-2">Control fee validity, auto-blocking, and payment approval.</p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="fees_validity_day" class="form-label">Fee validity day (1–28)</label>
                            <input type="number" name="fees_validity_day" id="fees_validity_day" class="form-control" value="{{ \App\Helpers\FeeConfig::validityDay() }}" min="1" max="28" placeholder="10">
                            <small class="text-body-secondary">Fees due by this day of month. Auto-block runs after.</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">Auto-block defaulters</label>
                            <div class="form-check form-switch mt-2">
                                <input type="hidden" name="fees_auto_block" value="0">
                                <input class="form-check-input" type="checkbox" name="fees_auto_block" id="fees_auto_block" value="1" {{ \App\Helpers\FeeConfig::autoBlockEnabled() ? 'checked' : '' }}>
                                <label class="form-check-label" for="fees_auto_block">Block portal if unpaid past validity day</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">Payment approval required</label>
                            <div class="form-check form-switch mt-2">
                                <input type="hidden" name="fees_require_approval" value="0">
                                <input class="form-check-input" type="checkbox" name="fees_require_approval" id="fees_require_approval" value="1" {{ \App\Helpers\FeeConfig::requirePaymentApproval() ? 'checked' : '' }}>
                                <label class="form-check-label" for="fees_require_approval">Manual approve before applying payment</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-12">
                            <h6 class="mb-2">Attendance deduction / fines</h6>
                            <p class="small text-body-secondary mb-2">When enabled, absences (and optionally Late) incur a fine added to arrears. Processed monthly via <code>attendance:process-deductions</code>.</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">Attendance fines enabled</label>
                            <div class="form-check form-switch mt-2">
                                <input type="hidden" name="attendance_fine_enabled" value="0">
                                <input class="form-check-input" type="checkbox" name="attendance_fine_enabled" id="attendance_fine_enabled" value="1" {{ \App\Helpers\FeeConfig::attendanceFineEnabled() ? 'checked' : '' }}>
                                <label class="form-check-label" for="attendance_fine_enabled">Add fines for Absent/Late to arrears</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="attendance_fine_per_absence" class="form-label">Fine per Absence</label>
                            <input type="number" name="attendance_fine_per_absence" id="attendance_fine_per_absence" class="form-control" value="{{ \App\Helpers\FeeConfig::attendanceFinePerAbsence() }}" min="0" step="0.01" placeholder="0">
                        </div>
                        <div class="col-md-4">
                            <label for="attendance_fine_per_late" class="form-label">Fine per Late (0 = no fine)</label>
                            <input type="number" name="attendance_fine_per_late" id="attendance_fine_per_late" class="form-control" value="{{ \App\Helpers\FeeConfig::attendanceFinePerLate() }}" min="0" step="0.01" placeholder="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
