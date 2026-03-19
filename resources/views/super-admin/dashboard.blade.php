@extends('layouts.super-admin')

@section('content')
@php
    $currency = \App\Models\Setting::get('currency', 'PKR');
    $pendingRegistrations = $pendingRegistrations ?? collect();
@endphp

@if(isset($overdueCount) && ($overdueCount > 0 || ($markedOverdue ?? 0) > 0))
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-danger border-0 d-flex align-items-center justify-content-between flex-wrap gap-3 mb-0 py-3">
            <div class="min-w-0 flex-grow-1">
                <strong><i class="fas fa-exclamation-triangle me-2"></i>Overdue fee vouchers</strong>
                <span class="ms-2">{{ $overdueCount }} invoice(s) past due date.</span>
                @if(($markedOverdue ?? 0) > 0)
                    <span class="d-block small mt-1">{{ $markedOverdue }} were just marked overdue.</span>
                @endif
            </div>
            <a href="{{ route('admin.invoices.index', ['status' => 'overdue']) }}" class="btn btn-sm btn-danger flex-shrink-0">View overdue</a>
        </div>
    </div>
</div>
@endif

{{-- Overview & Quick Links (top) --}}
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Overview & Quick Links</h4>
            </div>
            <div class="card-body pt-2">
                <div class="row g-3">
                    <div class="col-md-4 col-lg-2">
                        <div class="card card-body bg-primary bg-opacity-10 text-dark p-3 text-center">
                            <h4 class="mb-0">{{ $totalUsers ?? 0 }}</h4>
                            <small>Total Users</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ route('admin.enrollments.index') }}" class="card card-body bg-success bg-opacity-10 text-decoration-none text-dark p-3 text-center">
                            <h4 class="mb-0">{{ $totalEnrollments ?? 0 }}</h4>
                            <small>Enrollments</small>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ route('super-admin.expenses.index') }}" class="card card-body bg-danger bg-opacity-10 text-decoration-none text-dark p-3 text-center">
                            <h4 class="mb-0">{{ number_format($expensesThisYear ?? 0) }}</h4>
                            <small>Expenses (Year)</small>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="card card-body bg-warning bg-opacity-10 p-3 text-center">
                            <h4 class="mb-0">{{ number_format($feesPendingTotal ?? 0) }}</h4>
                            <small>Pending Dues {{ $currency }}</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ route('admin.invoices.index', ['status' => 'overdue']) }}" class="card card-body {{ ($overdueCount ?? 0) > 0 ? 'bg-danger' : 'bg-secondary' }} text-white text-decoration-none p-3 text-center">
                            <h4 class="mb-0">{{ $overdueCount ?? 0 }}</h4>
                            <small>Overdue Invoices</small>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ route('super-admin.registrations.index') }}" class="card card-body bg-info bg-opacity-10 text-decoration-none text-dark p-3 text-center">
                            <h4 class="mb-0">{{ $pendingRegistrations->count() }}</h4>
                            <small>Pending Approval</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Super Admin index-3 style stat cards --}}
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-primary overflow-hidden">
            <div class="card-header border-opacity">
                <h3 class="card-title text-white">Total Students</h3>
                <h5 class="text-white mb-0"><i class="fa fa-caret-up"></i> {{ $studentsCount ?? 0 }}</h5>
            </div>
            <div class="card-body text-center mt-3">
                <div class="ico-sparkline"><div id="sparkline12"></div></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-success overflow-hidden">
            <div class="card-header border-opacity">
                <h3 class="card-title text-white">New / Pending</h3>
                <h5 class="text-white mb-0"><i class="fa fa-caret-up"></i> {{ $pendingRegistrations->count() }}</h5>
            </div>
            <div class="card-body text-center mt-4 p-0">
                <div class="ico-sparkline"><div id="spark-bar-2"></div></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-secondary overflow-hidden">
            <div class="card-header border-opacity pb-3">
                <h3 class="card-title text-white">Total Courses</h3>
                <h5 class="text-white mb-0"><i class="fa fa-caret-up"></i> {{ $totalCourses ?? 0 }}</h5>
            </div>
            <div class="card-body p-0 mt-2">
                <div class="px-4"><span class="bar1" data-peity='{ "fill": ["rgb(0, 0, 128)", "rgb(7, 135, 234)"]}'>6,2,8,4,-3,8,1,-3,6,-5,9,2,-8,1,4,8,9,8,2,1</span></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="widget-stat card bg-danger overflow-hidden">
            <div class="card-header border-opacity pb-3">
                <h3 class="card-title text-white">Fees Collection</h3>
                <h5 class="text-white mb-0"><i class="fa fa-caret-up"></i> {{ number_format($feesCollectedTotal ?? 0) }}{{ $currency }}</h5>
            </div>
            <div class="card-body p-0 mt-1">
                <span class="peity-line-2" data-width="100%">7,6,8,7,3,8,3,3,6,5,9,2,8</span>
            </div>
        </div>
    </div>

    {{-- Charts row --}}
    <div class="col-xl-6 col-xxl-6 col-sm-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Income / Revenue</h3></div>
            <div class="card-body"><canvas id="barChart_2"></canvas></div>
        </div>
    </div>
    <div class="col-xl-6 col-xxl-6 col-sm-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Income / Expense</h3></div>
            <div class="card-body"><canvas id="areaChart_1"></canvas></div>
        </div>
    </div>

    {{-- Pending registrations (Assign Task style) + Notifications --}}
    <div class="col-xl-8 col-xxl-8 col-lg-8 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Pending Registrations</h5>
                @if($pendingRegistrations->count() > 0)
                    <span class="badge badge-rounded badge-warning ms-2">{{ $pendingRegistrations->count() }} awaiting</span>
                @endif
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email / Role</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingRegistrations as $u)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }} <span class="badge badge-light">{{ $u->role?->name ?? '—' }}</span></td>
                                    <td><span class="badge badge-rounded badge-warning">Pending</span></td>
                                    <td>
                                        <form method="post" action="{{ route('super-admin.registrations.approve', $u) }}" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-success">Approve</button></form>
                                        <form method="post" action="{{ route('super-admin.registrations.reject', $u) }}" class="d-inline" onsubmit="return confirm('Reject this registration?');">@csrf<button type="submit" class="btn btn-sm btn-outline-danger">Reject</button></form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No pending registrations.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-xxl-4 col-lg-4 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Notifications</h4></div>
            <div class="card-body">
                <div class="widget-todo dz-scroll" style="height:320px;" id="DZ_W_Notifications">
                    <ul class="timeline">
                        @forelse(($notifications ?? []) as $n)
                        <li>
                            <div class="timeline-badge primary"></div>
                            <a class="timeline-panel text-muted mb-3 d-flex align-items-center" href="{{ $n['url'] ?? '#' }}">
                                <div class="col px-3">
                                    <h5 class="mb-1">{{ $n['title'] ?? 'Notification' }}</h5>
                                    <small class="d-block">{{ $n['message'] ?? '' }}</small>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li>
                            <div class="timeline-badge success"></div>
                            <div class="timeline-panel text-muted mb-3">
                                <h5 class="mb-1">Dashboard</h5>
                                <small class="d-block">Total collected: {{ number_format($feesCollectedTotal ?? 0) }} {{ $currency }}</small>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge warning"></div>
                            <div class="timeline-panel text-muted mb-3">
                                <h5 class="mb-1">Active enrollments</h5>
                                <small class="d-block">{{ $activeEnrollments ?? 0 }} active students</small>
                            </div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="{{ asset('Dsimt-lms-assets/vendor/svganimation/vivus.min.js') }}"></script>
<script src="{{ asset('Dsimt-lms-assets/vendor/svganimation/svg.animation.js') }}"></script>
<script src="{{ asset('Dsimt-lms-assets/js/dashboard/dashboard-3.js') }}"></script>
@endsection
