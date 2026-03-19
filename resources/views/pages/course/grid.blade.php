@extends('layouts.landing', ['ulClass' => 'mx-auto', 'hideHeader' => true])

@section('content')
<!-- **************** MAIN CONTENT START **************** -->
<main>

    <!-- =======================
    Page Banner START -->
    <section class="bg-blue align-items-center d-flex"
        style="background:url(/images/pattern/04.png) no-repeat center center; background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <!-- Title -->
                    <h1 class="text-white">All Courses</h1>
                    <!-- Breadcrumb -->
                    <div class="d-flex justify-content-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-dark breadcrumb-dots mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All courses</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =======================
    Page Banner END -->

    <!-- =======================
    Page content START -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main content START -->
                <div class="col-12">

                    <!-- Search option START -->
                    <div class="row mb-4 align-items-center">
                        <!-- Search bar -->
                        <div class="col-xl-4">
                            <form class="border rounded p-2" method="get" action="{{ route('courses.index') }}">
                                <div class="input-group input-borderless input-group-sm">
                                    <input class="form-control form-control-sm me-1" type="search" name="q" placeholder="Find your course" value="{{ request('q') }}">
                                    <button type="submit" class="btn btn-primary btn-sm mb-0 rounded z-index-1"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <!-- Sort and Category dropdowns -->
                        <div class="col-xl-5 mt-3 mt-xl-0 d-flex align-items-center gap-2 flex-wrap">
                            <form method="get" action="{{ route('courses.index') }}" class="border rounded p-2 input-borderless" id="sortForm">
                                @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                                @if(request('mode'))<input type="hidden" name="mode" value="{{ request('mode') }}">@endif
                                @if(request('language'))<input type="hidden" name="language" value="{{ request('language') }}">@endif
                                <select class="form-select form-select-sm border-0" name="sort" aria-label="Sort" onchange="this.form.submit()">
                                    <option value="">Newest first</option>
                                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most enrolled</option>
                                </select>
                            </form>
                            <form method="get" action="{{ route('courses.index') }}" class="border rounded p-2 input-borderless" id="categoryForm">
                                @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                                @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                                @if(request('language'))<input type="hidden" name="language" value="{{ request('language') }}">@endif
                                <select class="form-select form-select-sm border-0" name="mode" aria-label="Category" onchange="this.form.submit()">
                                    <option value="">All categories</option>
                                    @foreach($courseModes as $mode)
                                    <option value="{{ $mode->id }}" {{ (string) request('mode') === (string) $mode->id ? 'selected' : '' }}>{{ $mode->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <!-- Result count -->
                        <div class="col-12 col-xl-3 mt-3 mt-xl-0 d-flex justify-content-xl-end align-items-center">
                            <!-- Advanced filter responsive toggler START -->
                            <button class="btn btn-primary btn-sm me-3 d-xl-none" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                                <i class="fas fa-sliders-h me-1"></i> Filters
                            </button>
                            <!-- Advanced filter responsive toggler END -->
                            <p class="mb-0 small text-dark">Showing {{ $courses->firstItem() ?? 0 }}-{{ $courses->lastItem() ?? 0 }} of {{ $courses->total() }} results</p>
                        </div>

                    </div>
                    <!-- Search option END -->

                    <!-- Course Grid START -->
                    <div class="row g-4">
                        @forelse($courses as $course)
                            @include('partials.course-card', ['course' => $course])
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted mb-0">No courses found.</p>
                                <a href="{{ route('courses.index') }}" class="btn btn-primary mt-3">Browse all courses</a>
                            </div>
                        @endforelse


                    </div>
                    <!-- Course Grid END -->

                    <!-- Pagination START -->
                    @if($courses->hasPages())
                    <div class="col-12">
                        <nav class="mt-4 d-flex justify-content-center" aria-label="navigation">
                            {{ $courses->links() }}
                        </nav>
                    </div>
                    @endif
                    <!-- Pagination END -->
                </div>
                <!-- Main content END -->

                <!-- Filters offcanvas (full-width layout: filters in drawer only) -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasSidebar">
                    <div class="offcanvas-header bg-light">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body p-3">
                        <form method="get" action="{{ route('courses.index') }}" id="filterForm">
                            @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                            @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif

                            <!-- Language -->
                            @if(($languages ?? collect())->isNotEmpty())
                            <div class="card card-body shadow p-4 mb-4">
                                <h4 class="mb-3">Language</h4>
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="language" value="" id="filterLangAll" {{ !request('language') ? 'checked' : '' }} onchange="this.form.submit()">
                                        <label class="form-check-label small" for="filterLangAll">All</label>
                                    </div>
                                    @foreach($languages as $lang)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="language" value="{{ $lang }}" id="filterLang{{ Str::slug($lang) }}" {{ request('language') === $lang ? 'checked' : '' }} onchange="this.form.submit()">
                                        <label class="form-check-label small" for="filterLang{{ Str::slug($lang) }}">{{ $lang }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div><!-- Row END -->
        </div>
    </section>
    <!-- =======================
    Page content END -->

</main>
<!-- **************** MAIN CONTENT END **************** -->

@endsection
