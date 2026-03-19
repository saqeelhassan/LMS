<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.partials/title-meta')

    @include('layouts.partials/head-css')

</head>

<body @yield('body-atribute')>

    @yield('header')

    @yield('content')

    <!-- Back to top -->
    <div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i></div>

    @include('layouts.partials/footer-scripts')

</body>

</html>