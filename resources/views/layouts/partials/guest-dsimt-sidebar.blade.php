{{-- Guest minimal sidebar (same dlabnav structure as dashboard) --}}
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Account</li>
            <li>
                <a href="{{ route('login') }}" class="ai-icon" aria-expanded="false">
                    <i class="la la-sign-in-alt"></i>
                    <span class="nav-text">Back to login</span>
                </a>
            </li>
        </ul>
        <div class="copyright">
            <p class="mb-0">LMS Digi Sindh &copy; {{ date('Y') }}</p>
        </div>
    </div>
</div>
