<!-- Left sidebar START -->
<div class="col-xl-3">
    <!-- Responsive offcanvas body START -->
    <div class="offcanvas-xl offcanvas-end" tabindex="-1" id="offcanvasSidebar">
        <!-- Offcanvas header -->
        <div class="offcanvas-header bg-white border-bottom">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">My profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
        </div>
        <!-- Offcanvas body -->
        <div class="offcanvas-body p-3 p-xl-0 bg-white">
            <div class="sidebar-menu-light border rounded-3 pb-0 p-3 w-100">
                <!-- Logo in sidebar -->
                <div class="text-center py-3 border-bottom mb-3">
                    <a class="d-inline-block" href="{{ route('dashboard') }}">
                        <img class="navbar-brand-item" src="{{ asset('images/logo.png') }}" alt="Digital Sindh" style="max-height: 40px; width: auto;">
                    </a>
                </div>
                <!-- Dashboard menu -->
                <div class="list-group list-group-borderless">
                    <a class="list-group-item list-group-item-light-sidebar sidebar-dashboard-link {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}" href="{{ route('instructor.dashboard') }}"><i class="bi bi-ui-checks-grid fa-fw me-2"></i>Dashboard</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('instructor.manage-course') ? 'active' : '' }}" href="{{ route('instructor.manage-course') }}"><i class="bi bi-basket fa-fw me-2"></i>My Courses</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('instructor.exams-manager.*') ? 'active' : '' }}" href="{{ route('instructor.exams-manager.index') }}"><i class="bi bi-journal-text fa-fw me-2"></i>Exams Manager</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('instructor.assignments.*') ? 'active' : '' }}" href="{{ route('instructor.manage-course') }}"><i class="bi bi-journal-plus fa-fw me-2"></i>Assignments</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('instructor.batches.*') ? 'active' : '' }}" href="{{ route('instructor.batches.index') }}"><i class="bi bi-people fa-fw me-2"></i>My Batches</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('instructor.courses.create') ? 'active' : '' }}" href="{{ route('instructor.courses.create') }}"><i class="bi bi-file-earmark-plus fa-fw me-2"></i>Create Course</a>
                    <a class="list-group-item list-group-item-light-sidebar" href="{{ route('courses.index') }}"><i class="bi bi-file-check fa-fw me-2"></i>Courses</a>
                    <div class="list-group-item list-group-item-light-sidebar text-danger bg-danger-soft-hover border-0 pt-2">
                        <form method="post" action="{{ route('auth.logout') }}" class="d-inline mb-0">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none d-flex align-items-center"><i class="fas fa-sign-out-alt fa-fw me-2"></i>Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Responsive offcanvas body END -->
</div>
<!-- Left sidebar END -->