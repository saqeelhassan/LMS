{{-- Instructor dlabnav sidebar (matches super-admin structure) --}}
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Instructor Menu</li>
            <li>
                <a href="{{ route('instructor.dashboard') }}" class="ai-icon {{ Request::is('instructor') && !Request::is('instructor/*') ? 'mm-active' : '' }}" aria-expanded="false">
                    <i class="la la-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a class="ai-icon" href="{{ route('instructor.manage-course') }}" aria-expanded="false">
                    <i class="la la-book"></i>
                    <span class="nav-text">My Courses</span>
                </a>
            </li>
            <li>
                <a class="ai-icon" href="{{ route('instructor.exams-manager.index') }}" aria-expanded="false">
                    <i class="la la-file-text"></i>
                    <span class="nav-text">Exams Manager</span>
                </a>
            </li>
            <li>
                <a class="ai-icon" href="{{ route('instructor.manage-course') }}" aria-expanded="false">
                    <i class="la la-edit"></i>
                    <span class="nav-text">Assignments</span>
                </a>
            </li>
            <li>
                <a class="ai-icon" href="{{ route('instructor.batches.index') }}" aria-expanded="false">
                    <i class="la la-users"></i>
                    <span class="nav-text">My Batches</span>
                </a>
            </li>
            <li>
                <a class="ai-icon" href="{{ route('instructor.courses.create') }}" aria-expanded="false">
                    <i class="la la-plus"></i>
                    <span class="nav-text">Create Course</span>
                </a>
            </li>
            <li>
                <a class="ai-icon" href="{{ route('courses.index') }}" aria-expanded="false">
                    <i class="la la-search"></i>
                    <span class="nav-text">Browse Courses</span>
                </a>
            </li>
            <li class="nav-label">Account</li>
            <li>
                <a class="ai-icon" href="{{ route('account.profile.edit') }}" aria-expanded="false">
                    <i class="la la-user"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            <li>
                <a class="ai-icon" href="{{ route('account.settings') }}" aria-expanded="false">
                    <i class="la la-cog"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
            <li>
                <a class="ai-icon" href="{{ route('help') }}" aria-expanded="false">
                    <i class="la la-question-circle"></i>
                    <span class="nav-text">Help</span>
                </a>
            </li>
        </ul>
    </div>
</div>
