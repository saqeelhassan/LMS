@extends('layouts.admin')

@section('content')
@php
    $currency = \App\Models\Setting::get('currency', 'PKR');
@endphp

@if(isset($overdueCount) && ($overdueCount > 0 || ($markedOverdue ?? 0) > 0))
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-danger border-0 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-0">
            <div>
                <strong><i class="fas fa-exclamation-triangle me-2"></i>Overdue fee vouchers</strong>
                <span class="ms-2">{{ $overdueCount }} invoice(s) past due date.</span>
                @if(($markedOverdue ?? 0) > 0)
                    <span class="d-block small mt-1">{{ $markedOverdue }} were just marked overdue.</span>
                @endif
            </div>
            <a href="{{ route('admin.invoices.index', ['status' => 'overdue']) }}" class="btn btn-sm btn-danger">View overdue</a>
        </div>
    </div>
</div>
@endif

{{-- Admin index-2: 4 stat cards + Income chart --}}
<div class="row">
    <div class="col-xl-6 col-xxl-6 col-sm-12">
        <div class="row">
            <div class="col-xl-6 col-xxl-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body">
                        <h4 class="card-title">Total Students</h4>
                        <h3 class="fw-bold">{{ $studentsCount ?? 0 }}</h3>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-animated bg-primary" style="width: {{ min(100, ($studentsCount ?? 0) ? 80 : 0) }}%"></div>
                        </div>
                        <small>Active students</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body">
                        <h4 class="card-title">New Enrollments</h4>
                        <h3 class="fw-bold">{{ $newEnrollmentsCount ?? 0 }}</h3>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-animated bg-danger" style="width: {{ min(100, ($newEnrollmentsCount ?? 0) ? 50 : 0) }}%"></div>
                        </div>
                        <small>Last 30 days</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body">
                        <h4 class="card-title">Total Course</h4>
                        <h3 class="fw-bold">{{ $totalCourses ?? 0 }}</h3>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-animated bg-red" style="width: {{ min(100, ($totalCourses ?? 0) ? 76 : 0) }}%"></div>
                        </div>
                        <small>Courses</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body">
                        <h4 class="card-title">Fees Collection</h4>
                        <h3 class="fw-bold">{{ number_format($feesCollectedTotal ?? 0) }}{{ $currency }}</h3>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-animated bg-success" style="width: 60%"></div>
                        </div>
                        <small>Total collected</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-xxl-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Income / Revenue</h3>
            </div>
            <div class="card-body">
                <div id="ChartEarnings" style="min-height: 280px;"></div>
            </div>
        </div>
    </div>

    {{-- Professors List (index-2 style) --}}
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Instructors</h4>
            </div>
            <div class="card-body dz-scroll" style="height: 360px;">
                @forelse($instructors ?? [] as $inst)
                <div class="media mb-3 align-items-center border-bottom pb-3">
                    @if($inst->avatar_url)
                        <img class="me-3 rounded-circle" alt="" width="50" height="50" src="{{ $inst->avatar_url }}" style="object-fit:cover;">
                    @else
                        <span class="me-3 rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:50px;height:50px;font-size:1.1rem;">{{ substr($inst->name ?? 'I', 0, 1) }}</span>
                    @endif
                    <div class="media-body">
                        <h5 class="mb-0 text-pale-sky">{{ $inst->name }} <small class="text-muted">( {{ $inst->email }} )</small></h5>
                        <small class="text-primary mb-0">Instructor</small>
                    </div>
                </div>
                @empty
                <p class="text-muted mb-0">No instructors.</p>
                @endforelse
            </div>
            <div class="card-footer border-0 pt-2">
                <div class="text-center">
                    <a href="{{ route('admin.registrations.index') }}" class="btn btn-primary">Pending Registrations</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Student List (index-2 style) --}}
    <div class="col-xl-8 col-lg-8 col-xxl-8 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Recent Enrollments</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive recentOrderTable text-nowrap">
                    <table class="table verticle-middle table-responsive-md">
                        <thead>
                            <tr>
                                <th scope="col">Student Name</th>
                                <th scope="col">Course</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEnrollmentsForList ?? [] as $e)
                            <tr>
                                <td>{{ $e->user->name ?? $e->user->email }}</td>
                                <td>{{ $e->course->name ?? '—' }}</td>
                                <td>{{ $e->created_at?->format('d M Y') }}</td>
                                <td><span class="badge badge-rounded badge-{{ $e->enrollment_status === 'active' ? 'primary' : ($e->enrollment_status === 'dropped' ? 'danger' : 'warning') }}">{{ $e->enrollment_status ?? '—' }}</span></td>
                                <td>
                                    <div class="dropdown custom-dropdown mb-0">
                                        <div data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('admin.enrollments.index') }}">View</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No recent enrollments.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if(isset($attendanceOverview) && (auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('batches.manage')))
    <div class="col-12">
        <a href="{{ route('admin.attendance.index') }}" class="text-decoration-none">
            <div class="card card-body bg-light border p-4">
                <h6 class="mb-2"><i class="fas fa-fingerprint me-2"></i>Today's attendance (biometric)</h6>
                <div class="row g-2 small">
                    <div class="col-md-6">
                        <span class="text-body">Students:</span>
                        <strong>{{ $attendanceOverview['student_present_count'] ?? 0 }}/{{ $attendanceOverview['student_expected_count'] ?? 0 }}</strong>
                        <span class="text-success">({{ $attendanceOverview['student_present_percent'] ?? 0 }}% present)</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-body">Instructors:</span>
                        <strong>{{ $attendanceOverview['instructor_present_count'] ?? 0 }}</strong> present,
                        <strong class="text-danger">{{ $attendanceOverview['instructor_absent_count'] ?? 0 }}</strong> absent
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var earningsOptions = {
        chart: { type: 'area', height: 280, toolbar: { show: false } },
        series: [{ name: 'Revenue', data: @json($earningsValues ?? []) }],
        xaxis: { categories: @json($earningsLabels ?? []) },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.1 } },
        colors: ['#07294d'],
        tooltip: { y: { formatter: function(v) { return v ? (parseFloat(v).toFixed(2) + '') : '0'; } } }
    };
    var earningsEl = document.getElementById('ChartEarnings');
    if (earningsEl) new ApexCharts(earningsEl, earningsOptions).render();
});
</script>
@endsection
