{{-- Student dlabnav sidebar (same structure as super-admin) --}}
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li>
                <a href="{{ route('student.dashboard') }}" class="ai-icon {{ request()->routeIs('student.dashboard') ? 'mm-active' : '' }}" aria-expanded="false">
                    <i class="la la-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ route('student.subscription') }}" aria-expanded="false"><i class="la la-list"></i><span class="nav-text">My Subscriptions</span></a></li>
            <li><a class="ai-icon" href="{{ route('student.course-resume') }}" aria-expanded="false"><i class="la la-play"></i><span class="nav-text">Course Resume</span></a></li>
            <li><a class="ai-icon {{ request()->routeIs('student.exams*') ? 'mm-active' : '' }}" href="{{ route('student.exams.index') }}" aria-expanded="false"><i class="la la-file-text"></i><span class="nav-text">Exams</span></a></li>
            <li><a class="ai-icon {{ request()->routeIs('student.assignments*') ? 'mm-active' : '' }}" href="{{ route('student.assignments.index') }}" aria-expanded="false"><i class="la la-tasks"></i><span class="nav-text">Assignments</span></a></li>
            <li><a class="ai-icon {{ request()->routeIs('student.quiz*') ? 'mm-active' : '' }}" href="{{ route('student.quiz') }}" aria-expanded="false"><i class="la la-question-circle"></i><span class="nav-text">Quiz</span></a></li>
            <li><a class="ai-icon {{ request()->routeIs('student.fee-status') || request()->routeIs('student.payment-info') ? 'mm-active' : '' }}" href="{{ route('student.fee-status') }}" aria-expanded="false"><i class="la la-credit-card"></i><span class="nav-text">Fee Status</span></a></li>
            <li><a class="ai-icon {{ request()->routeIs('student.attendance*') ? 'mm-active' : '' }}" href="{{ route('student.attendance.index') }}" aria-expanded="false"><i class="la la-calendar-check-o"></i><span class="nav-text">My Attendance</span></a></li>
            <li><a class="ai-icon {{ request()->routeIs('student.events*') ? 'mm-active' : '' }}" href="{{ route('student.events.index') }}" aria-expanded="false"><i class="la la-calendar"></i><span class="nav-text">Events</span></a></li>
            <li><a class="ai-icon {{ request()->routeIs('student.id-card') ? 'mm-active' : '' }}" href="{{ route('student.id-card') }}" aria-expanded="false"><i class="la la-id-card"></i><span class="nav-text">Digital ID Card</span></a></li>
            <li><a class="ai-icon {{ request()->routeIs('student.certificates*') ? 'mm-active' : '' }}" href="{{ route('student.certificates') }}" aria-expanded="false"><i class="la la-certificate"></i><span class="nav-text">Certificates</span></a></li>
            <!-- Wishlist removed per request -->
        </ul>
        <div class="copyright">
            <p class="mb-0">LMS Digi Sindh &copy; {{ date('Y') }}</p>
        </div>
    </div>
</div>
