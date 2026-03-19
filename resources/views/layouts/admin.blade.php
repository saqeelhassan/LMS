<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.title-meta')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    {{-- Admin dashboard UI assets (index-2) --}}
    <link rel="stylesheet" href="{{ asset('Dsimt-lms-assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Dsimt-lms-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('Dsimt-lms-assets/css/nav-logo-toggle.css') }}">
    @yield('css')
</head>
<body>

    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <div id="main-wrapper">
        @include('layouts.partials.admin-dsimt-nav-header')
        @include('layouts.partials.admin-dsimt-header')
        @include('layouts.partials.admin-dsimt-sidebar')

        <div class="content-body">
            <div class="container-fluid">
                @include('layouts.partials.view-as-banner')
                @yield('content')
            </div>
            @include('layouts.partials.view-as-modals')
        </div>

        <div class="footer">
            <div class="copyright">
                <p class="mb-0">LMS Digi Sindh &copy; {{ date('Y') }}. DIGITAL SINDH INSTITUTE OF MANAGEMENT AND TECHNOLOGY</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('Dsimt-lms-assets/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('Dsimt-lms-assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('Dsimt-lms-assets/js/custom.min.js') }}"></script>
    <script src="{{ asset('Dsimt-lms-assets/js/dlabnav-init.js') }}"></script>
    @yield('scripts')
</body>
</html>
