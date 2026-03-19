<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.partials/title-meta')

    @include('layouts.partials/head-css')

</head>

<body>

    <main>

        <!-- =======================
    Page Banner START -->
        <section class="pt-0">
            <div class="container-fluid px-0">
                <div class="card bg-blue h-100px h-md-200px rounded-0 d-flex align-items-center justify-content-center"
                    style="background:url(/images/pattern/04.png) no-repeat center center; background-size:cover;">
                    @if ($account == 'instructor')
                    <h1 class="h3 mb-0 text-white fw-bold">Instructor Dashboard</h1>
                    @endif
                </div>
            </div>
            @if ($account == 'student')
                @include('layouts.partials.student-topbar')
            @elseif ($account == 'instructor')
                @include('layouts.partials.instructor-topbar')
            @endif
        </section>

        @include('layouts.partials.view-as-banner')

        <!-- =======================
    Page content START -->
        <section class="pt-0">
            <div class="container">
                <div class="row">
                    @if ($account == 'student')
                        @include('layouts.partials.student-sidebar')
                    @elseif ($account == 'instructor')
                        @include('layouts.partials.instructor-sidebar')
                    @endif

                    @yield('content')
                </div>
            </div>
        </section>
        <!-- =======================
    Page content END -->
    </main>
    <!-- **************** MAIN CONTENT END **************** -->
    <!-- Back to top -->
    <div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i></div>

    @include('layouts.partials/footer-scripts')

</body>

</html>
