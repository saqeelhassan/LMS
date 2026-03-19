{{-- Admin dlabnav sidebar (index-2 structure) --}}
@php
    $pendingPayments = \App\Models\Payment::where('status', 'pending_approval')->count();
@endphp
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            @if(auth()->user()->role?->name === 'SuperAdmin')
            <li class="nav-label first">Super Admin</li>
            <li><a class="ai-icon" href="{{ route('super-admin.dashboard') }}"><i class="la la-shield"></i><span class="nav-text">Super Admin Panel</span></a></li>
            <li class="nav-label">Main Menu</li>
            @endif
            <li><a class="ai-icon {{ Request::is('admin') && !Request::is('admin/*') ? 'mm-active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="la la-home"></i><span class="nav-text">Dashboard</span></a></li>
            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('courses.manage'))
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-graduation-cap"></i><span class="nav-text">Courses</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.courses.index') }}">All Courses</a></li>
                    @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('courses.create'))
                    <li><a href="{{ route('admin.courses.create') }}">Add Courses</a></li>
                    @endif
                    <li><a href="{{ route('admin.courses.about') }}">About Courses</a></li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('enrollments.view'))
            <li><a class="ai-icon" href="{{ route('admin.enrollments.index') }}"><i class="la la-list"></i><span class="nav-text">Enrollments</span></a></li>
            @endif
            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('users.view'))
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-user"></i><span class="nav-text">Professors</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.professors.index') }}">All Professors</a></li>
                    <li><a href="{{ route('admin.professors.create') }}">Add Professor</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-user-graduate"></i><span class="nav-text">Students</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.students.index') }}">All Students</a></li>
                    <li><a href="{{ route('admin.students.create') }}">Add Student</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-id-badge"></i><span class="nav-text">Staff</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.staff.index') }}">All Staff</a></li>
                    <li><a href="{{ route('admin.staff.create') }}">Add Staff</a></li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('registrations.approve'))
            <li><a class="ai-icon" href="{{ route('admin.registrations.index') }}"><i class="la la-user-plus"></i><span class="nav-text">Pending Registrations</span></a></li>
            @endif
            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('batches.manage'))
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-calendar"></i><span class="nav-text">Batches</span></a>
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
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-dollar"></i><span class="nav-text">Fee & Finance</span>@if($pendingPayments > 0)<span class="badge badge-sm badge-warning ms-2">{{ $pendingPayments }}</span>@endif</a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.fee-management.index') }}">Fees Collection</a></li>
                    <li><a href="{{ route('admin.invoices.create') }}">Add Fees</a></li>
                    <li><a href="{{ route('admin.invoices.index') }}">Fees Receipt</a></li>
                    <li><a href="{{ route('admin.fee-management.ledger') }}">Student Ledger</a></li>
                    <li><a href="{{ route('admin.defaulters.index') }}">Defaulter List</a></li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('inquiries.manage'))
            <li><a class="ai-icon" href="{{ route('admin.inquiries.index') }}"><i class="la la-phone"></i><span class="nav-text">Inquiries</span></a></li>
            @endif
            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('notifications.manage'))
            <li><a class="ai-icon" href="{{ route('admin.broadcasts.index') }}"><i class="la la-bullhorn"></i><span class="nav-text">Broadcasts</span></a></li>
            @endif
            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('inquiries.manage'))
            <li class="nav-label">Website</li>
            <li><a class="ai-icon" href="{{ route('admin.blogs.index') }}"><i class="la la-file-text"></i><span class="nav-text">Blogs</span></a></li>
            <li><a class="ai-icon" href="{{ route('admin.contact-messages.index') }}"><i class="la la-envelope"></i><span class="nav-text">Contact Messages</span></a></li>
            <li><a class="ai-icon" href="{{ route('admin.career-applications.index') }}"><i class="la la-briefcase"></i><span class="nav-text">Career Applications</span></a></li>
            @endif
        </ul>
        <div class="copyright">
            <p class="mb-0">LMS Digi Sindh &copy; {{ date('Y') }}</p>
        </div>
    </div>
</div>
