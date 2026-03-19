{{-- Admin sidebar (same icnav UI as Super Admin) --}}
@php
    $pendingPayments = \App\Models\Payment::where('status', 'pending_approval')->count();
@endphp
<div class="icnav">
    <div class="icnav-scroll">
        <ul class="metismenu list-unstyled" id="menu">
            @if(auth()->user()->role?->name === 'SuperAdmin')
            <li class="menu-title">SUPER ADMIN</li>
            <li>
                <a href="{{ route('super-admin.dashboard') }}" class="{{ Request::is('super-admin*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-shield-lock"></i></div>
                    <span class="nav-text">Super Admin Panel</span>
                </a>
            </li>
            <li class="menu-title">MAIN</li>
            @endif

            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ Request::is('admin') && !Request::is('admin/*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-house"></i></div>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('courses.manage'))
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <div class="menu-icon"><i class="bi bi-basket"></i></div>
                    <span class="nav-text">Courses</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.courses.index') }}">All Courses</a></li>
                    @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('courses.create'))
                    <li><a href="{{ route('admin.courses.create') }}">Add Course</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('enrollments.view'))
            <li>
                <a href="{{ route('admin.enrollments.index') }}" class="{{ Request::is('admin/enrollments*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-journal-check"></i></div>
                    <span class="nav-text">Enrollments</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('registrations.approve'))
            <li>
                <a href="{{ route('admin.registrations.index') }}" class="{{ Request::is('admin/registrations*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-person-check"></i></div>
                    <span class="nav-text">Pending Registrations</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('batches.manage'))
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <div class="menu-icon"><i class="bi bi-calendar-week"></i></div>
                    <span class="nav-text">Batches</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.batches.index') }}">All Batches</a></li>
                    <li><a href="{{ route('admin.batches.create') }}">Add Batch</a></li>
                    <li><a href="{{ route('admin.batch-management.index') }}">Batch Management</a></li>
                    <li><a href="{{ route('admin.attendance.index') }}">Attendance & Payroll</a></li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('fees.manage'))
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <div class="menu-icon"><i class="bi bi-currency-dollar"></i></div>
                    <span class="nav-text">Fee & Finance</span>
                    @if($pendingPayments > 0)<span class="badge bg-warning text-dark ms-auto">{{ $pendingPayments }}</span>@endif
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.fee-management.index') }}">Fee Management</a></li>
                    <li><a href="{{ route('admin.fee-management.ledger') }}">Student Ledger</a></li>
                    <li><a href="{{ route('admin.invoices.index') }}">Invoices</a></li>
                    <li><a href="{{ route('admin.defaulters.index') }}">Defaulter List</a></li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('batches.manage'))
            <li>
                <a href="{{ route('admin.attendance.index') }}" class="{{ Request::is('admin/attendance*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-cash-stack"></i></div>
                    <span class="nav-text">Pay Management</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('inquiries.manage'))
            <li>
                <a href="{{ route('admin.inquiries.index') }}" class="{{ Request::is('admin/inquiries*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-telephone-inbound"></i></div>
                    <span class="nav-text">Inquiries</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('notifications.manage'))
            <li>
                <a href="{{ route('admin.broadcasts.index') }}" class="{{ Request::is('admin/broadcasts*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-megaphone"></i></div>
                    <span class="nav-text">Broadcasts</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
    <div class="icnav-footer">
        <a href="{{ route('index') }}" class="btn btn-sm btn-outline-secondary w-100" target="_blank" rel="noopener">
            <i class="bi bi-globe me-1"></i> Main website
        </a>
    </div>
</div>
