{{-- Super Admin dlabnav sidebar (matches index-3 structure) --}}
@php
    $pendingCourses = \App\Models\Course::where('publication_status', 'pending_approval')->count();
@endphp
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li>
                <a href="{{ route('super-admin.dashboard') }}" class="ai-icon {{ Request::is('super-admin') && !Request::is('super-admin/*') ? 'mm-active' : '' }}" aria-expanded="false">
                    <i class="la la-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ route('super-admin.registrations.index') }}" aria-expanded="false"><i class="la la-user-plus"></i><span class="nav-text">Pending Registrations</span></a></li>
            <li>
                <a class="ai-icon" href="{{ route('super-admin.course-approval.index') }}"><i class="la la-book"></i><span class="nav-text">Course Approvals</span>@if($pendingCourses > 0)<span class="badge badge-sm badge-warning ms-2">{{ $pendingCourses }}</span>@endif</a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-graduation-cap"></i><span class="nav-text">Courses</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.courses.index') }}">All Courses</a></li>
                    <li><a href="{{ route('admin.courses.create') }}">Add Courses</a></li>
                    <li><a href="{{ route('admin.courses.about') }}">About Courses</a></li>
                </ul>
            </li>
            <li><a class="ai-icon" href="{{ route('admin.enrollments.index') }}"><i class="la la-list"></i><span class="nav-text">Enrollments</span></a></li>
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
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-dollar"></i><span class="nav-text">Fee & Finance</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.fee-management.index') }}">Fees Collection</a></li>
                    <li><a href="{{ route('admin.invoices.create') }}">Add Fees</a></li>
                    <li><a href="{{ route('admin.invoices.index') }}">Fees Receipt</a></li>
                    <li><a href="{{ route('admin.fee-management.ledger') }}">Student Ledger</a></li>
                    <li><a href="{{ route('admin.defaulters.index') }}">Defaulter List</a></li>
                </ul>
            </li>
            <li class="nav-label">Website</li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-globe"></i><span class="nav-text">Website Operations</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.blogs.index') }}">Blogs</a></li>
                    <li><a href="{{ route('admin.contact-messages.index') }}">Contact Messages</a></li>
                    <li><a href="{{ route('admin.career-applications.index') }}">Career Applications</a></li>
                </ul>
            </li>
            <li class="nav-label">System</li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="la la-calendar"></i><span class="nav-text">Batches</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('super-admin.batches.index') }}">All Batches</a></li>
                    <li><a href="{{ route('super-admin.batches.create') }}">Add Batch</a></li>
                    <li><a href="{{ route('super-admin.batch-management.index') }}">Batch Management</a></li>
                </ul>
            </li>
            <li><a class="ai-icon" href="{{ route('super-admin.branches.index') }}"><i class="la la-building"></i><span class="nav-text">Branches</span></a></li>
            <li><a class="ai-icon" href="{{ route('super-admin.settings.index') }}"><i class="la la-cog"></i><span class="nav-text">Global Settings</span></a></li>
            <li><a class="ai-icon" href="{{ route('super-admin.expenses.index') }}"><i class="la la-money"></i><span class="nav-text">Expenses</span></a></li>
            <li><a class="ai-icon" href="{{ route('super-admin.audit-logs.index') }}"><i class="la la-file-text"></i><span class="nav-text">Audit Logs</span></a></li>
            <li class="nav-label">View As</li>
            <li><a class="ai-icon" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalViewAsAdmin"><i class="la la-shield"></i><span class="nav-text">Admin Panel</span></a></li>
            <li><a class="ai-icon" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalViewAsInstructor"><i class="la la-user"></i><span class="nav-text">Instructor View</span></a></li>
            <li><a class="ai-icon" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalViewAsStudent"><i class="la la-video-camera"></i><span class="nav-text">Student View</span></a></li>
        </ul>
        <div class="copyright">
            <p class="mb-0">LMS Digi Sindh &copy; {{ date('Y') }}</p>
        </div>
    </div>
</div>
