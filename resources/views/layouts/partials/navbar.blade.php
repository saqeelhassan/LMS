@if (isset($topHeader))
<!-- Top header START -->
<div class="navbar-top navbar-dark bg-light d-none d-xl-block py-2 mx-2 mx-md-4 rounded-bottom-4">
    <div class="container">
        <div class="d-lg-flex justify-content-lg-between align-items-center">
            <!-- Navbar top Left-->
            <!-- Top info -->
            <ul class="nav align-items-center justify-content-center">
                <li class="nav-item me-3" data-bs-toggle="tooltip" data-bs-animation="false" data-bs-placement="bottom"
                    data-bs-original-title="Sunday CLOSED">
                    <span><i class="far fa-clock me-2"></i>Visit time: Mon-Sat 9:00-19:00</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-headset me-2"></i>Call us now:
                        +135-869-328</a>
                </li>
            </ul>

            <!-- Navbar top Right-->
            <div class="nav d-flex align-items-center justify-content-center">
                <!-- Language -->
                <div class="dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownLanguage"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                            class="fas fa-globe me-2"></i>Language</a>
                    <div class="dropdown-menu mt-2 min-w-auto shadow" aria-labelledby="dropdownLanguage">
                        <a class="dropdown-item me-4" href="#"><img class="fa-fw me-2"
                                src="/images/flags/uk.svg" alt="">English</a>
                        <a class="dropdown-item me-4" href="#"><img class="fa-fw me-2"
                                src="/images/flags/sp.svg" alt="">Español</a>
                        <a class="dropdown-item me-4" href="#"><img class="fa-fw me-2"
                                src="/images/flags/fr.svg" alt="">Français</a>
                        <a class="dropdown-item me-4" href="#"><img class="fa-fw me-2"
                                src="/images/flags/gr.svg" alt="">Deutsch</a>
                    </div>
                </div>

                <!-- Top social -->
                <ul class="list-unstyled d-flex mb-0">
                    <li> <a class="px-2 nav-link" href="#"><i class="fab fa-facebook"></i></a> </li>
                    <li> <a class="px-2 nav-link" href="#"><i class="fab fa-instagram"></i></a> </li>
                    <li> <a class="px-2 nav-link" href="#"><i class="fab fa-twitter"></i></a> </li>
                    <li> <a class="ps-2 nav-link" href="#"><i class="fab fa-linkedin-in"></i></a> </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Top header END -->

@elseif (isset($topAlert))
<!-- Top alert START -->
<div class="container">
    <div class="alert alert-success alert-dismissible d-flex justify-content-between align-items-center fade show mt-2 mb-0 rounded-3 pe-2"
        role="alert">
        <div>
            <!-- Avatar -->
            <div class="avatar avatar-xs me-2">
                <img class="avatar-img rounded-circle" src="/images/avatar/09.jpg" alt="avatar">
            </div>
            <!-- Info -->
            The personality development class starts at 2:00 pm, click to <a href="#" class="alert-link">Join
                Now</a>
        </div>
        <button type="button" class="btn btn-link text-primary-hover mb-0 text-end" data-bs-dismiss="alert"
            aria-label="Close"><i class="bi bi-x-lg"></i></button>
    </div>
</div>
<!-- Top alert END -->
@endif

<!-- Header START -->
<header class="navbar-light navbar-sticky {{ isset($headerClass) ? $headerClass : '' }}" @yield('header-attribute')>
    <!-- Nav START -->
    <nav class="navbar navbar-expand-xl{{ isset($navClass) ? $navClass : '' }}">
        <div class="container{{ isset($containerClass) ? $containerClass : '' }}">
            <!-- Logo START (hidden when instructor - logo is in sidebar) -->
            @if(empty($account) || $account !== 'instructor')
            <a class="navbar-brand" href="{{ auth()->check() ? route('dashboard') : route('login') }}">
                <img class="light-mode-item navbar-brand-item" src="{{ asset('images/logo.png') }}" alt="LMS">
                <img class="dark-mode-item navbar-brand-item" src="{{ asset('images/logo.png') }}" alt="LMS">
            </a>
            @endif
            <!-- Logo END -->

            <!-- Responsive navbar toggler -->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-animation">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <!-- Main navbar START -->
            <div class="navbar-collapse w-100 collapse" id="navbarCollapse">
                <ul class="navbar-nav navbar-nav-scroll {{ isset($ulClass) ? $ulClass : '' }}">
                </ul>
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link me-2">Register</a></li>
                        <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-sm btn-primary mb-0">Login</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <!-- Nav END -->
</header>
<!-- Header END -->
