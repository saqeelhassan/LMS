{{-- Sidebar (icnav) with logo and Super Admin menu --}}
@php
    $pendingCourses = \App\Models\Course::where('publication_status', 'pending_approval')->count();
@endphp
<div class="icnav">
    <div class="icnav-scroll">
        <ul class="metismenu list-unstyled" id="menu">
            <li class="menu-title">MAIN</li>
            <li>
                <a href="{{ route('super-admin.dashboard') }}" class="{{ Request::is('super-admin') && !Request::is('super-admin/*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-house"></i></div>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.registrations.index') }}" class="{{ Request::is('super-admin/registrations') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-person-plus"></i></div>
                    <span class="nav-text">Pending Registrations</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.course-approval.index') }}" class="{{ Request::is('super-admin/course-approval*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-journal-check"></i></div>
                    <span class="nav-text">Course Approvals</span>
                    @if($pendingCourses > 0)
                        <span class="badge bg-warning text-dark ms-auto">{{ $pendingCourses }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <div class="menu-icon"><i class="bi bi-basket"></i></div>
                    <span class="nav-text">Courses</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.courses.index') }}">All Courses</a></li>
                    <li><a href="{{ route('admin.courses.create') }}">Add Course</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.enrollments.index') }}" class="{{ Request::is('admin/enrollments*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-journal-check"></i></div>
                    <span class="nav-text">Enrollments</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <div class="menu-icon"><i class="bi bi-currency-dollar"></i></div>
                    <span class="nav-text">Fee & Finance</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.fee-management.index') }}">Fee Management</a></li>
                    <li><a href="{{ route('admin.fee-management.ledger') }}">Student Ledger</a></li>
                    <li><a href="{{ route('admin.invoices.index') }}">Invoices</a></li>
                    <li><a href="{{ route('admin.defaulters.index') }}">Defaulter List</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.attendance.index') }}" class="{{ Request::is('admin/attendance*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-calendar-check"></i></div>
                    <span class="nav-text">Attendance</span>
                </a>
            </li>
            <li class="menu-title">WEBSITE</li>
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <div class="menu-icon"><i class="bi bi-globe2"></i></div>
                    <span class="nav-text">Website Operations</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.blogs.index') }}">Blogs</a></li>
                    <li><a href="{{ route('admin.contact-messages.index') }}">Contact Messages</a></li>
                    <li><a href="{{ route('admin.career-applications.index') }}">Career Applications</a></li>
                </ul>
            </li>
            <li class="menu-title">SYSTEM</li>
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <div class="menu-icon"><i class="bi bi-calendar-week"></i></div>
                    <span class="nav-text">Batches</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('super-admin.batches.index') }}">All Batches</a></li>
                    <li><a href="{{ route('super-admin.batches.create') }}">Add Batch</a></li>
                    <li><a href="{{ route('super-admin.batch-management.index') }}">Batch Management</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('super-admin.branches.index') }}" class="{{ Request::is('super-admin/branches*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-geo-alt"></i></div>
                    <span class="nav-text">Branches</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.settings.index') }}" class="{{ Request::is('super-admin/settings*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-gear"></i></div>
                    <span class="nav-text">Global Settings</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.expenses.index') }}" class="{{ Request::is('super-admin/expenses*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-receipt"></i></div>
                    <span class="nav-text">Expenses</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.audit-logs.index') }}" class="{{ Request::is('super-admin/audit-logs*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-journal-text"></i></div>
                    <span class="nav-text">Audit Logs</span>
                </a>
            </li>
            <li class="menu-title">VIEW AS</li>
            <li>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalViewAsAdmin">
                    <div class="menu-icon"><i class="bi bi-shield-lock"></i></div>
                    <span class="nav-text">Admin Panel</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalViewAsInstructor">
                    <div class="menu-icon"><i class="bi bi-person-badge"></i></div>
                    <span class="nav-text">Instructor View</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalViewAsStudent">
                    <div class="menu-icon"><i class="bi bi-person-video3"></i></div>
                    <span class="nav-text">Student View</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="icnav-footer">
        <a href="{{ route('index') }}" class="btn btn-sm btn-outline-secondary w-100" target="_blank" rel="noopener">
            <i class="bi bi-globe me-1"></i> Main website
        </a>
    </div>
</div>
