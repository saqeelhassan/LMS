@extends('layouts.landing', ['ulClass' => 'mx-auto', 'hideHeader' => true])

@section('content')
<!-- **************** MAIN CONTENT START **************** -->
<main>

    <!-- =======================
    Page intro START -->
    <section class="bg-light py-3 py-sm-4">
        <div class="container">
            <div class="row py-3 py-md-4">
                <div class="col-lg-8">
                    <h6 class="mb-2 font-base bg-primary text-white py-2 px-3 rounded-2 d-inline-block">{{ $course->courseMode?->name ?? 'Course' }}</h6>
                    <h1 class="mb-2">{{ $course->name }}</h1>
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i class="fas fa-user-graduate text-orange me-2"></i>{{ $course->enrollments_count ?? 0 }} Enrolled</li>
                        <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i class="bi bi-patch-exclamation-fill text-danger me-2"></i>Updated {{ $course->updated_at?->format('m/Y') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- =======================
    Page intro END -->

    <!-- =======================
    Page content START -->
    <section class="pb-0 py-3 py-lg-4">
        <div class="container">
            <div class="row">
                <!-- Left sidebar START -->
                <div class="col-lg-4 order-2 order-lg-1 pt-3 pt-lg-0">
                    <div class="row mb-0">
                        <div class="col-md-6 col-lg-12">
                            <!-- Video START -->
                            <div class="card shadow p-2 mb-3 z-index-9">
                                <div class="overflow-hidden rounded-3">
                                    <img src="{{ $course->image_url }}" class="card-img" alt="{{ $course->name }}">
                                    <!-- Overlay -->
                                    <div class="bg-overlay bg-dark opacity-6"></div>
                                    @if($course->live_class_url ?? null)
                                    <div class="card-img-overlay d-flex align-items-start flex-column p-3">
                                        <div class="m-auto">
                                            <a href="{{ $course->live_class_url }}"
                                                class="btn btn-lg text-danger btn-round btn-white-shadow mb-0"
                                                target="_blank" rel="noopener">
                                                <i class="fas fa-play"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Card body -->
                                <div class="card-body px-3 py-3">
                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show small mb-2" role="alert">
                                            {!! session('success') !!}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if(session('info'))
                                        <div class="alert alert-info alert-dismissible fade show small mb-2" role="alert">
                                            {{ session('info') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-end align-items-center mb-2">
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-sm btn-light rounded small" role="button" id="dropdownShare" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-fw fa-share-alt"></i> Share
                                            </a>
                                            <ul class="dropdown-menu dropdown-w-sm dropdown-menu-end min-w-auto shadow rounded" aria-labelledby="dropdownShare">
                                                <li><a class="dropdown-item" href="#"><i class="fab fa-twitter-square me-2"></i>Twitter</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fab fa-facebook-square me-2"></i>Facebook</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fab fa-linkedin me-2"></i>LinkedIn</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Copy link</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    @if($isEnrolled ?? false)
                                        <div class="alert alert-success small mb-0">You're enrolled in this course.</div>
                                        <div class="mt-3">
                                            <a href="{{ route('student.courses') }}" class="btn btn-success mb-0 w-100">Go to My Courses</a>
                                        </div>
                                    @elseif(($canReapply ?? false) && isset($rejectedEnrollment))
                                        <div class="alert alert-warning small mb-2">Your previous application was not approved. You can re-apply below.</div>
                                        @if($rejectedEnrollment->rejection_note)
                                            <p class="small text-muted mb-2"><strong>Reason:</strong> {{ $rejectedEnrollment->rejection_note }}</p>
                                        @endif
                                        <form action="{{ route('enrollments.reapply', $rejectedEnrollment) }}" method="post" class="mt-2">
                                            @csrf
                                            <button type="submit" class="btn btn-primary mb-0 w-100">Re-apply for this course</button>
                                        </form>
                                        <p class="small text-muted mt-2 mb-0">Your application will be reviewed again by the admin.</p>
                                    @elseif($rejectedNoReapply ?? false)
                                        <div class="alert alert-secondary small mb-0">Your application for this course was not approved. Re-application is not available for this enrollment.</div>
                                        <a href="{{ route('student.courses') }}" class="btn btn-outline-secondary mt-2 w-100">My Courses</a>
                                    @elseif(auth()->check())
                                        @php
                                            $pendingEnrollment = $course->enrollments()->where('user_id', auth()->id())->where('enrollment_status', 'pending_approval')->first();
                                        @endphp
                                        @if($pendingEnrollment)
                                            <div class="alert alert-info small mb-0">Your application is pending approval. You will be notified once reviewed.</div>
                                            <a href="{{ route('student.courses') }}" class="btn btn-outline-secondary mt-2 w-100">My Courses</a>
                                        @else
                                        <form action="{{ route('courses.enroll', $course) }}" method="post" class="mt-2">
                                            @csrf
                                            @if(isset($paymentMethods) && $paymentMethods->isNotEmpty())
                                                <div class="mb-2">
                                                    <label for="payment_method_id" class="form-label small mb-0">Payment method (optional)</label>
                                                    <select name="payment_method_id" id="payment_method_id" class="form-select form-select-sm">
                                                        <option value="">— None —</option>
                                                        @foreach($paymentMethods as $pm)
                                                            <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            <button type="submit" class="btn btn-success mb-0 w-100">Enroll in this course</button>
                                        </form>
                                        @endif
                                    @else
                                        <p class="small text-muted mb-2">Sign in to enroll and access the course.</p>
                                        <a href="{{ route('login') }}?intended={{ urlencode(request()->url()) }}" class="btn btn-success mb-0 w-100">Sign in to enroll</a>
                                    @endif
                                </div>
                            </div>
                            <!-- Video END -->

                            <!-- Course info START -->
                            <div class="card card-body shadow p-3 mb-0">
                                <h5 class="mb-2">This course includes</h5>
                                <ul class="list-group list-group-borderless list-group-flush small">
                                    <li class="list-group-item py-2 d-flex justify-content-between align-items-center">
                                        <span class="fw-light"><i class="fas fa-fw fa-book-open text-primary me-2"></i>Lectures</span>
                                        <span>{{ $course->total_lectures ?? $course->contents->count() ?? '—' }}</span>
                                    </li>
                                    @if($course->total_hours ?? null)
                                    <li class="list-group-item py-2 d-flex justify-content-between align-items-center">
                                        <span class="fw-light"><i class="fas fa-fw fa-clock text-primary me-2"></i>Duration</span>
                                        <span>{{ $course->total_hours }}</span>
                                    </li>
                                    @endif
                                    @if($course->skills ?? null)
                                    <li class="list-group-item py-2 d-flex justify-content-between align-items-center">
                                        <span class="fw-light"><i class="fas fa-fw fa-signal text-primary me-2"></i>Skills</span>
                                        <span>{{ $course->skills }}</span>
                                    </li>
                                    @endif
                                    @if($course->language ?? null)
                                    <li class="list-group-item py-2 d-flex justify-content-between align-items-center">
                                        <span class="fw-light"><i class="fas fa-fw fa-globe text-primary me-2"></i>Language</span>
                                        <span>{{ $course->language }}</span>
                                    </li>
                                    @endif
                                    @if($course->release_date ?? null)
                                    <li class="list-group-item py-2 d-flex justify-content-between align-items-center">
                                        <span class="fw-light"><i class="fas fa-fw fa-calendar text-primary me-2"></i>Release</span>
                                        <span>{{ $course->release_date->format('M j, Y') }}</span>
                                    </li>
                                    @endif
                                    <li class="list-group-item py-2 d-flex justify-content-between align-items-center">
                                        <span class="fw-light"><i class="fas fa-fw fa-medal text-primary me-2"></i>Certificate</span>
                                        <span>{{ $course->certificate ? 'Yes' : 'No' }}</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- Course info END -->
                        </div>

                    </div><!-- Row End -->
                </div>
                <!-- Left sidebar END -->

                <!-- Main content START -->
                <div class="col-lg-8 order-1 order-lg-2">
                    <div class="card shadow rounded-2 p-0">
                        <!-- Tabs START -->
                        <div class="card-header border-bottom px-3 py-2">
                            <ul class="nav nav-pills nav-tabs-line py-0" id="course-pills-tab" role="tablist">
                                <!-- Tab item -->
                                <li class="nav-item me-2 me-sm-4" role="presentation">
                                    <button class="nav-link mb-2 mb-md-0 active" id="course-pills-tab-1"
                                        data-bs-toggle="pill" data-bs-target="#course-pills-1" type="button"
                                        role="tab" aria-controls="course-pills-1"
                                        aria-selected="true">Overview</button>
                                </li>
                                <!-- Tab item -->
                                <li class="nav-item me-2 me-sm-4" role="presentation">
                                    <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-2"
                                        data-bs-toggle="pill" data-bs-target="#course-pills-2" type="button"
                                        role="tab" aria-controls="course-pills-2"
                                        aria-selected="false">Curriculum</button>
                                </li>
                                <!-- Tab item -->
                                <li class="nav-item me-2 me-sm-4" role="presentation">
                                    <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-3"
                                        data-bs-toggle="pill" data-bs-target="#course-pills-3" type="button"
                                        role="tab" aria-controls="course-pills-3"
                                        aria-selected="false">Instructor</button>
                                </li>
                                <!-- Tab item -->
                                <li class="nav-item me-2 me-sm-4" role="presentation">
                                    <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-4"
                                        data-bs-toggle="pill" data-bs-target="#course-pills-4" type="button"
                                        role="tab" aria-controls="course-pills-4"
                                        aria-selected="false">Reviews</button>
                                </li>
                                <!-- Tab item -->
                                <li class="nav-item me-2 me-sm-4" role="presentation">
                                    <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-5"
                                        data-bs-toggle="pill" data-bs-target="#course-pills-5" type="button"
                                        role="tab" aria-controls="course-pills-5" aria-selected="false">FAQs
                                    </button>
                                </li>
                                <!-- Tab item -->
                                <li class="nav-item me-2 me-sm-4" role="presentation">
                                    <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-6"
                                        data-bs-toggle="pill" data-bs-target="#course-pills-6" type="button"
                                        role="tab" aria-controls="course-pills-6"
                                        aria-selected="false">Comment</button>
                                </li>
                            </ul>
                        </div>
                        <!-- Tabs END -->

                        <!-- Tab contents START -->
                        <div class="card-body p-3">
                            <div class="tab-content pt-1" id="course-pills-tabContent">
                                <!-- Content START -->
                                <div class="tab-pane fade show active" id="course-pills-1" role="tabpanel"
                                    aria-labelledby="course-pills-tab-1">
                                    <h5 class="mb-2">Course Description</h5>
                                    <div class="mb-0 text-body">
                                        {!! nl2br(e($course->description ?? 'No description available.')) !!}
                                    </div>
                                    @if($course->skills)
                                    <h5 class="mt-3 mb-2">What you'll learn</h5>
                                    <ul class="list-group list-group-borderless mb-0">
                                        @foreach(array_filter(array_map('trim', preg_split('/[,;\n]+/', $course->skills))) as $skill)
                                        <li class="list-group-item h6 fw-light d-flex mb-0"><i class="fas fa-check-circle text-success me-2"></i>{{ $skill }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    <!-- Course detail END -->

                                </div>
                                <!-- Content END -->

                                <!-- Content START -->
                                <div class="tab-pane fade" id="course-pills-2" role="tabpanel"
                                    aria-labelledby="course-pills-tab-2">
                                    <!-- Curriculum: course contents -->
                                    <ul class="list-group list-group-borderless">
                                        @forelse($course->contents as $content)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                @if(($content->type ?? '') === 'video' || $content->url)
                                                <a href="{{ $content->url ?? '#' }}" class="btn btn-danger-soft btn-round btn-sm mb-0 me-2" target="_blank" rel="noopener"><i class="fas fa-play me-0"></i></a>
                                                @else
                                                <span class="btn btn-light btn-round btn-sm mb-0 me-2"><i class="fas fa-file-alt me-0"></i></span>
                                                @endif
                                                <span class="h6 fw-light mb-0">{{ $content->title }}</span>
                                            </div>
                                            <span class="badge bg-light text-dark">{{ ucfirst($content->type ?? 'content') }}</span>
                                        </li>
                                        @empty
                                        <li class="list-group-item text-muted">No curriculum content yet.</li>
                                        @endforelse
                                    </ul>
                                    
                                </div>
                                <!-- Content END -->

                                <!-- Content START -->
                                <div class="tab-pane fade" id="course-pills-3" role="tabpanel"
                                    aria-labelledby="course-pills-tab-3">
                                    @if($course->instructor)
                                    <div class="card mb-0 mb-md-4">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-md-5">
                                                <img src="{{ $course->instructor->avatar_url ?? '/images/avatar/01.jpg' }}" class="img-fluid rounded-3" alt="{{ $course->instructor->name }}">
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body">
                                                    <h3 class="card-title mb-0">{{ $course->instructor->name }}</h3>
                                                    <p class="mb-2">{{ $course->courseMode?->name ?? 'Instructor' }}</p>
                                                    @if($course->instructor->email)
                                                    <p class="mb-0"><a href="mailto:{{ $course->instructor->email }}">{{ $course->instructor->email }}</a></p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <p class="text-muted mb-0">No instructor assigned for this course.</p>
                                    @endif
                                </div>
                                <!-- Content END -->

                                <!-- Content START -->
                                <div class="tab-pane fade" id="course-pills-4" role="tabpanel"
                                    aria-labelledby="course-pills-tab-4">
                                    <h5 class="mb-3">Reviews</h5>
                                    <p class="text-muted mb-0">No reviews yet for this course.</p>

</div>
                                <!-- Content END -->

                                <!-- Content START -->
                                                                <div class="tab-pane fade" id="course-pills-5" role="tabpanel"
                                    aria-labelledby="course-pills-tab-5">
                                    <!-- Title -->
                                    <h5 class="mb-3">FAQs</h5>
                                    <p class="text-muted mb-0">No FAQs for this course yet.</p>
                                <div class="tab-pane fade" id="course-pills-6" role="tabpanel"
                                    aria-labelledby="course-pills-tab-6">
                                    <h5 class="mb-3">Comments</h5>
                                    <p class="text-muted mb-0">No comments yet. Sign in to leave a comment.</p>
                                                                    </div>
                                <!-- Content END -->

                            </div>
                        </div>
                        <!-- Tab contents END -->
                    </div>
                </div>
                <!-- Main content END -->

            </div><!-- Row END -->
        </div>
    </section>
    <!-- =======================
    Page content END -->



</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- Modal START -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 bg-transparent">
                <!-- Close button -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body px-5 pb-5 position-relative overflow-hidden">

                <!-- Element -->
                <figure class="position-absolute bottom-0 end-0 mb-n4 me-n4 d-none d-sm-block">
                    <img src="/images/element/01.svg" alt="element">
                </figure>
                <figure class="position-absolute top-0 end-0 z-index-n1 opacity-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="818.6px" height="235.1px" viewBox="0 0 818.6 235.1">
                        <path class="fill-info"
                            d="M735,226.3c-5.7,0.6-11.5,1.1-17.2,1.7c-66.2,6.8-134.7,13.7-192.6-16.6c-34.6-18.1-61.4-47.9-87.3-76.7 c-21.4-23.8-43.6-48.5-70.2-66.7c-53.2-36.4-121.6-44.8-175.1-48c-13.6-0.8-27.5-1.4-40.9-1.9c-46.9-1.9-95.4-3.9-141.2-16.5 C8.3,1.2,6.2,0.6,4.2,0H0c3.3,1,6.6,2,10,3c46,12.5,94.5,14.6,141.5,16.5c13.4,0.6,27.3,1.1,40.8,1.9 c53.4,3.2,121.5,11.5,174.5,47.7c26.5,18.1,48.6,42.7,70,66.5c26,28.9,52.9,58.8,87.7,76.9c58.3,30.5,127,23.5,193.3,16.7 c5.8-0.6,11.5-1.2,17.2-1.7c26.2-2.6,55-4.2,83.5-2.2v-1.2C790,222,761.2,223.7,735,226.3z">
                        </path>
                    </svg>
                </figure>
                <!-- Title -->
                <h2>Get Premium Course in <span class="text-success">$800</span></h2>
                <p>Prosperous understood Middletons in conviction an uncommonly do. Supposing so be resolving breakfast
                    am or perfectly.</p>
                <!-- Content -->
                <div class="row mb-3 item-collapse">
                    <div class="col-sm-6">
                        <ul class="list-group list-group-borderless">
                            <li class="list-group-item text-body"> <i
                                    class="bi bi-patch-check-fill text-success"></i>High quality Curriculum</li>
                            <li class="list-group-item text-body"> <i
                                    class="bi bi-patch-check-fill text-success"></i>Tuition Assistance</li>
                            <li class="list-group-item text-body"> <i
                                    class="bi bi-patch-check-fill text-success"></i>Diploma course</li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-group list-group-borderless">
                            <li class="list-group-item text-body"> <i
                                    class="bi bi-patch-check-fill text-success"></i>Intermediate courses</li>
                            <li class="list-group-item text-body"> <i
                                    class="bi bi-patch-check-fill text-success"></i>Over 200 online courses</li>
                        </ul>
                    </div>
                </div>
                <!-- Button -->
                <a href="#" class="btn btn-lg btn-orange-soft">Purchase premium</a>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer d-block bg-info">
                <div class="d-sm-flex justify-content-sm-between align-items-center text-center text-sm-start">
                    <!-- Social media button -->
                    <ul class="list-inline mb-0 social-media-btn mb-2 mb-sm-0">
                        <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-facebook"
                                href="#"><i class="fab fa-fw fa-facebook-f"></i></a> </li>
                        <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-instagram"
                                href="#"><i class="fab fa-fw fa-instagram"></i></a> </li>
                        <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-twitter"
                                href="#"><i class="fab fa-fw fa-twitter"></i></a> </li>
                        <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-linkedin"
                                href="#"><i class="fab fa-fw fa-linkedin-in"></i></a> </li>
                    </ul>
                    <!-- Contact info -->
                    <div>
                        <p class="mb-1 small"><a href="#" class="text-white"><i
                                    class="far fa-envelope fa-fw me-2"></i>example@gmail.com</a></p>
                        <p class="mb-0 small"><a href="#" class="text-white"><i
                                    class="fas fa-headset fa-fw me-2"></i>123-456-789</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal END -->
@endsection