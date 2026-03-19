<!-- Sidebar START (structure matches admin-sidenav for theme CSS) -->
<nav class="navbar sidebar sidebar-light navbar-expand-xl navbar-light">
    <!-- Navbar brand for xl -->
    <div class="d-flex align-items-center">
        <a class="navbar-brand" href="{{ route('super-admin.dashboard') }}">
            <img class="navbar-brand-item" src="{{ asset('images/logo.png') }}" alt="LMS">
        </a>
    </div>

    <div class="offcanvas offcanvas-start flex-row custom-scrollbar h-100" data-bs-backdrop="true" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
        <div class="offcanvas-body sidebar-content d-flex flex-column">

            <ul class="navbar-nav flex-column" id="navbar-sidebar">
                <li class="nav-item">
                    <a href="{{ route('super-admin.dashboard') }}" class="nav-link sidebar-dashboard-link {{ Request::is('super-admin') && !Request::is('super-admin/users*') ? 'active' : '' }}">
                        <i class="bi bi-house fa-fw me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super-admin.registrations.index') }}" class="nav-link {{ Request::is('super-admin/registrations') ? 'active' : '' }}">
                        <i class="bi bi-person-plus fa-fw me-2"></i>Pending registrations
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super-admin.course-approval.index') }}" class="nav-link {{ Request::is('super-admin/course-approval*') ? 'active' : '' }}">
                        <i class="bi bi-journal-check fa-fw me-2"></i>Course Approvals
                        @php $pendingCourses = \App\Models\Course::where('publication_status', 'pending_approval')->count(); @endphp
                        @if($pendingCourses > 0)
                            <span class="badge bg-warning text-dark ms-1">{{ $pendingCourses }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#collapseCourses" role="button" aria-expanded="false" aria-controls="collapseCourses">
                        <i class="bi bi-basket fa-fw me-2"></i>Courses
                    </a>
                    <ul class="nav collapse flex-column" id="collapseCourses" data-bs-parent="#navbar-sidebar">
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.courses.index') }}">All Courses</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.courses.create') }}">Add course</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.enrollments.index') }}" class="nav-link {{ Request::is('admin/enrollments*') ? 'active' : '' }}">
                        <i class="bi bi-journal-check fa-fw me-2"></i>Enrollments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#collapseFees" role="button" aria-expanded="false" aria-controls="collapseFees">
                        <i class="bi bi-currency-dollar fa-fw me-2"></i>Fee & Finance
                    </a>
                    <ul class="nav collapse flex-column" id="collapseFees" data-bs-parent="#navbar-sidebar">
                        <li class="nav-item"><a class="nav-link {{ Request::is('admin/fee-management') && !Request::is('admin/fee-management/ledger') ? 'active' : '' }}" href="{{ route('admin.fee-management.index') }}">Fee Management</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('admin/fee-management/ledger') ? 'active' : '' }}" href="{{ route('admin.fee-management.ledger') }}">Student Ledger</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('admin/invoices*') ? 'active' : '' }}" href="{{ route('admin.invoices.index') }}">Invoices</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('admin/defaulters*') ? 'active' : '' }}" href="{{ route('admin.defaulters.index') }}">Defaulter List</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.attendance.index') }}" class="nav-link {{ Request::is('admin/attendance*') ? 'active' : '' }}">
                        <i class="bi bi-cash-stack fa-fw me-2"></i>Pay Management
                    </a>
                </li>
                <li class="nav-item mt-2"><span class="nav-link text-secondary small">Website</span></li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#collapseWebsiteOps" role="button" aria-expanded="false" aria-controls="collapseWebsiteOps">
                        <i class="bi bi-globe2 fa-fw me-2"></i>Website Operations
                    </a>
                    <ul class="nav collapse flex-column" id="collapseWebsiteOps" data-bs-parent="#navbar-sidebar">
                        <li class="nav-item"><a class="nav-link {{ Request::is('admin/blogs*') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">Blogs</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('admin/contact-messages*') ? 'active' : '' }}" href="{{ route('admin.contact-messages.index') }}">Contact Messages</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('admin/career-applications*') ? 'active' : '' }}" href="{{ route('admin.career-applications.index') }}">Career Applications</a></li>
                    </ul>
                </li>
                <li class="nav-item mt-2"><span class="nav-link text-secondary small">System</span></li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#collapseBatches" role="button" aria-expanded="false" aria-controls="collapseBatches">
                        <i class="bi bi-calendar-week fa-fw me-2"></i>Batches
                    </a>
                    <ul class="nav collapse flex-column" id="collapseBatches" data-bs-parent="#navbar-sidebar">
                        <li class="nav-item"><a class="nav-link {{ Request::is('super-admin/batches') && !Request::is('super-admin/batches/create') && !Request::is('super-admin/batches/*/edit') ? 'active' : '' }}" href="{{ route('super-admin.batches.index') }}">All Batches</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('super-admin/batches/create') ? 'active' : '' }}" href="{{ route('super-admin.batches.create') }}">Add Batch</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('super-admin/batch-management*') ? 'active' : '' }}" href="{{ route('super-admin.batch-management.index') }}">Batch Management Console</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super-admin.branches.index') }}" class="nav-link {{ Request::is('super-admin/branches*') ? 'active' : '' }}">
                        <i class="bi bi-geo-alt fa-fw me-2"></i>Branch Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super-admin.settings.index') }}" class="nav-link {{ Request::is('super-admin/settings*') ? 'active' : '' }}">
                        <i class="bi bi-gear fa-fw me-2"></i>Global Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super-admin.expenses.index') }}" class="nav-link {{ Request::is('super-admin/expenses*') ? 'active' : '' }}">
                        <i class="bi bi-receipt fa-fw me-2"></i>Expenses
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super-admin.audit-logs.index') }}" class="nav-link {{ Request::is('super-admin/audit-logs*') ? 'active' : '' }}">
                        <i class="bi bi-journal-text fa-fw me-2"></i>Audit Logs
                    </a>
                </li>
                <li class="nav-item mt-2"><span class="nav-link text-secondary small">View as</span></li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalViewAsAdmin"><i class="bi bi-shield-lock fa-fw me-2"></i>Admin Panel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalViewAsInstructor"><i class="bi bi-person-badge fa-fw me-2"></i>Instructor View</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalViewAsStudent"><i class="bi bi-person-video3 fa-fw me-2"></i>Student View</a>
                </li>
            </ul>

            <div class="px-3 mt-auto pt-3">
                <div class="d-flex align-items-center justify-content-between text-primary-hover">
                    <a class="h5 mb-0 text-body" href="{{ route('super-admin.dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Dashboard"><i class="bi bi-gear-fill"></i></a>
                    <a class="h5 mb-0 text-body" href="{{ route('login') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Home"><i class="bi bi-globe"></i></a>
                    <form method="post" action="{{ route('auth.logout') }}" class="d-inline">@csrf<button type="submit" class="btn btn-link p-0 h5 mb-0 text-body border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Sign out"><i class="bi bi-power"></i></button></form>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Sidebar END -->
