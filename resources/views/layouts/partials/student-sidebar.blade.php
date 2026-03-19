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
            <div class="sidebar-menu-light border rounded-3 p-3 w-100">
                <!-- Dashboard menu -->
                <div class="list-group list-group-borderless collapse-list">
                    <a class="list-group-item list-group-item-light-sidebar sidebar-dashboard-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}"><i class="bi bi-ui-checks-grid fa-fw me-2"></i>Dashboard</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('student.courses') ? 'active' : '' }}" href="{{ route('student.courses') }}"><i class="bi bi-journal-bookmark fa-fw me-2"></i>My Courses</a>
                    <a class="list-group-item list-group-item-light-sidebar" href="{{ route('student.subscription') }}"><i class="bi bi-card-checklist fa-fw me-2"></i>My Subscriptions</a>
                    <a class="list-group-item list-group-item-light-sidebar" href="{{ route('student.course-resume') }}"><i class="far fa-fw fa-file-alt me-2"></i>Course Resume</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('student.exams*') ? 'active' : '' }}" href="{{ route('student.exams.index') }}"><i class="bi bi-journal-text fa-fw me-2"></i>Exams</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('student.assignments*') ? 'active' : '' }}" href="{{ route('student.assignments.index') }}"><i class="bi bi-journal-check fa-fw me-2"></i>Assignments</a>
                    <a class="list-group-item list-group-item-light-sidebar" href="{{ route('student.quiz') }}"><i class="bi bi-question-diamond fa-fw me-2"></i>Quiz</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('student.fee-status') || request()->routeIs('student.payment-info') ? 'active' : '' }}" href="{{ route('student.fee-status') }}"><i class="bi bi-credit-card-2-front fa-fw me-2"></i>Fee Status</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('student.attendance*') ? 'active' : '' }}" href="{{ route('student.attendance.index') }}"><i class="bi bi-calendar-check fa-fw me-2"></i>My Attendance</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('student.events*') ? 'active' : '' }}" href="{{ route('student.events.index') }}"><i class="bi bi-calendar-event fa-fw me-2"></i>Events</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('student.id-card') ? 'active' : '' }}" href="{{ route('student.id-card') }}"><i class="bi bi-person-badge fa-fw me-2"></i>Digital ID Card</a>
                    <a class="list-group-item list-group-item-light-sidebar {{ request()->routeIs('student.certificates*') ? 'active' : '' }}" href="{{ route('student.certificates') }}"><i class="bi bi-award fa-fw me-2"></i>Certificates</a>
                    <!-- Wishlist removed -->
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
