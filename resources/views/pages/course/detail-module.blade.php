@extends('layouts.landing', ['ulClass' => 'mx-auto'])

@section('content')
<!-- **************** MAIN CONTENT START **************** -->
<main>

    <!-- =======================
    Page intro START -->
    <section class="bg-blue py-7">
        <div class="container">
            <div class="row justify-content-lg-between">

                <div class="col-lg-8">
                    <!-- Title -->
                    <h1 class="text-white">The Complete Digital Marketing Course - 12 Courses in 1</h1>
                    <p class="text-white">Satisfied conveying a dependent contented he gentleman agreeable do be.
                        Warrant private blushes removed an in equally totally if. Delivered dejection necessary
                        objection do Mr prevailed. Mr feeling does chiefly cordial in do.</p>

                    <!-- Content -->
                    <ul class="list-inline mb-5">
                        <li class="list-inline-item h6 me-4 mb-1 mb-sm-0 text-white"><span class="fw-light">By</span>
                            Lori Stevens</li>
                        <li class="list-inline-item me-4 mb-1 mb-sm-0">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                                <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                                <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                                <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                                <li class="list-inline-item me-0 small"><i
                                        class="fas fa-star-half-alt text-warning"></i></li>
                                <li class="list-inline-item ms-2 h6 text-white">4.5/5.0</li>
                                <li class="list-inline-item text-white">(1,586 reviews)</li>
                            </ul>
                        </li>
                        <li class="list-inline-item h6 mb-0 text-white"><i
                                class="fas fa-globe text-info me-2"></i>English</li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h6 class="text-white lead fw-light mb-3"><i
                            class="fas fa-user-graduate text-orange me-2"></i>12,155 already enrolled</h6>
                    <!-- Button -->
                    <a href="#" class="btn btn-warning mb-3 w-100">Enroll Course</a>

                    <!-- Progress item -->
                    <div class="overflow-hidden mb-4">
                        <h6 class="text-white">Your Progress</h6>
                        <div class="progress progress-sm bg-white bg-opacity-10 mb-1">
                            <div class="progress-bar bg-white aos" role="progressbar" data-aos="slide-right"
                                data-aos-delay="200" data-aos-duration="1000" data-aos-easing="ease-in-out"
                                style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-white">08 of 135 Completed</small>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- =======================
    Page intro END -->

    <!-- =======================
    Page content START -->
    <section class="pt-0">
        <div class="container">
            <div class="row">
                <!-- Main content START -->
                <div class="col-12">
                    <div class="card shadow rounded-2 p-0 mt-n5">
                        <!-- Tabs START -->
                        <div class="card-header border-bottom px-4 pt-3 pb-0">
                            <ul class="nav nav-bottom-line py-0" id="course-pills-tab" role="tablist">
                                <!-- Tab item -->
                                <li class="nav-item me-2 me-sm-4" role="presentation">
                                    <button class="nav-link mb-2 mb-md-0 active" id="course-pills-tab-1"
                                        data-bs-toggle="pill" data-bs-target="#course-pills-1" type="button"
                                        role="tab" aria-controls="course-pills-1" aria-selected="true">Course
                                        Materials</button>
                                </li>
                                <!-- Tab item -->
                                <li class="nav-item me-2 me-sm-4" role="presentation">
                                    <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-2"
                                        data-bs-toggle="pill" data-bs-target="#course-pills-2" type="button"
                                        role="tab" aria-controls="course-pills-2"
                                        aria-selected="false">Notes</button>
                                </li>
                                <!-- Tab item -->
                                <li class="nav-item me-2 me-sm-4" role="presentation">
                                    <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-3"
                                        data-bs-toggle="pill" data-bs-target="#course-pills-3" type="button"
                                        role="tab" aria-controls="course-pills-3"
                                        aria-selected="false">Discussion</button>
                                </li>
                            </ul>
                        </div>
                        <!-- Tabs END -->

                        <!-- Tab contents START -->
                        <div class="card-body p-sm-4">
                            <div class="tab-content" id="course-pills-tabContent">
                                <!-- Content START -->
                                <div class="tab-pane fade show active" id="course-pills-1" role="tabpanel"
                                    aria-labelledby="course-pills-tab-1">
                                    <!-- Accordion START -->
                                    <div class="accordion accordion-icon accordion-border" id="accordionExample2">
                                        <!-- Item -->
                                        <div class="accordion-item mb-3">
                                            <h6 class="accordion-header font-base" id="heading-1">
                                                <button class="accordion-button fw-bold rounded d-flex collapsed"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-1" aria-expanded="true"
                                                    aria-controls="collapse-1">
                                                    Week 1 -
                                                    <span class="small ms-2">April 15 - 20</span>
                                                    <span class="small ms-0 ms-sm-2 d-none d-sm-block">(4 Items)</span>

                                                    <!-- Mark button -->
                                                    <span class="text-secondary ms-auto pe-4" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Mark as completed">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </span>
                                                </button>
                                            </h6>

                                            <div id="collapse-1" class="accordion-collapse collapse show"
                                                aria-labelledby="heading-1" data-bs-parent="#accordionExample2">
                                                <div class="accordion-body mt-3">
                                                    <!-- Course lecture -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <!-- Video button -->
                                                            <a data-glightbox data-gallery="office-tour"
                                                                href="https://www.youtube.com/embed/tXHviS-4ygo"
                                                                class="icon-md position-relative">
                                                                <img src="/images/courses/4by3/01.jpg"
                                                                    class="rounded-1" alt="">
                                                                <small
                                                                    class="text-white position-absolute top-50 start-50 translate-middle"><i
                                                                        class="fas fa-play me-0 "></i></small>
                                                            </a>

                                                            <!-- Content -->
                                                            <div class="ms-3">
                                                                <a href="#"
                                                                    class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">
                                                                    What is Digital Marketing What is Digital
                                                                    Marketing</a>
                                                                <ul class="nav nav-divider small mb-0">
                                                                    <li class="nav-item">15m 10s</li>
                                                                    <li class="nav-item">20pts</li>
                                                                    <li class="nav-item"><a href="#"
                                                                            class="text-success">Submitted</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <!-- Actions Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-success"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Completed">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course assignment -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-fw fa-file-signature fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">Assignments
                                                                        1 - Research about marketing</a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">20pts</li>
                                                                        <li class="nav-item"><a
                                                                                href="#">Submit</a></li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Actions Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-success"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Completed">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course slide -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-fw fa-file-alt fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#slideModal">
                                                                        Slide - Digital Marketing
                                                                    </a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">View</li>
                                                                        <li class="nav-item">05 Slide</li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Actions -->
                                                        <div class="hstack gap-2 align-items-center">
                                                            <!-- Resume button -->
                                                            <a class="btn btn-sm btn-primary mb-0"
                                                                data-bs-toggle="collapse" href="#addnote-1"
                                                                role="button" aria-expanded="false">
                                                                <span class="d-none d-sm-block">Resume</span>
                                                                <span class="d-sm-none"><i
                                                                        class="bi bi-play-fill"></i></span>
                                                            </a>

                                                            <!-- Mark button -->
                                                            <a href="#" class="p-2 mb-0 text-secondary"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Mark as Complete">
                                                                <i class="bi bi-check-circle-fill"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course slide -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-question-circle fa-fw fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">Quiz
                                                                        - Digital Marketing</a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">12 April</li>
                                                                        <li class="nav-item">10 pts</li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Actions Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-secondary"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Item -->
                                        <div class="accordion-item mb-3">
                                            <h6 class="accordion-header font-base" id="heading-2">
                                                <button class="accordion-button fw-bold collapsed rounded d-flex"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-2" aria-expanded="false"
                                                    aria-controls="collapse-2">
                                                    Week 2 -
                                                    <span class="small ms-2">April 22 - 24</span>
                                                    <span class="small ms-0 ms-sm-2 d-none d-sm-block">(3 Items)</span>
                                                </button>
                                            </h6>
                                            <div id="collapse-2" class="accordion-collapse collapse"
                                                aria-labelledby="heading-2" data-bs-parent="#accordionExample2">
                                                <!-- Accordion body START -->
                                                <div class="accordion-body mt-3">

                                                    <!-- Course assignment -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-fw fa-file-signature fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">Assignments
                                                                        2 - Research about customer life cycle</a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">20pts</li>
                                                                        <li class="nav-item"><a
                                                                                href="#">Submit</a></li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Actions Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-secondary"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course assignment -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-fw fa-file-signature fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">Assignments
                                                                        3 - SEO Optimization</a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">20pts</li>
                                                                        <li class="nav-item"><a
                                                                                href="#">Submit</a></li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Actions Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-secondary"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course slide -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-fw fa-file-alt fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#slideModal">
                                                                        Slide - Type of Marketing
                                                                    </a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">View</li>
                                                                        <li class="nav-item">05 Slide</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-secondary"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                </div>
                                                <!-- Accordion body END -->
                                            </div>
                                        </div>

                                        <!-- Item -->
                                        <div class="accordion-item mb-3">
                                            <h6 class="accordion-header font-base" id="heading-3">
                                                <button class="accordion-button fw-bold collapsed rounded d-flex"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-3" aria-expanded="false"
                                                    aria-controls="collapse-3">
                                                    Week 3 -
                                                    <span class="small ms-2">April 28 - May 05</span>
                                                    <span class="small ms-0 ms-sm-2 d-none d-sm-block">(3 Items)</span>
                                                </button>
                                            </h6>
                                            <div id="collapse-3" class="accordion-collapse collapse"
                                                aria-labelledby="heading-3" data-bs-parent="#accordionExample2">
                                                <!-- Accordion body START -->
                                                <div class="accordion-body mt-3">

                                                    <!-- Course assignment -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-fw fa-file-signature fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">Assignments
                                                                        2 - Research about customer life cycle</a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">20pts</li>
                                                                        <li class="nav-item"><a
                                                                                href="#">Submit</a></li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Actions Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-secondary"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course assignment -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-fw fa-file-signature fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">Assignments
                                                                        3 - SEO Optimization</a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">20pts</li>
                                                                        <li class="nav-item"><a
                                                                                href="#">Submit</a></li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Actions Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-secondary"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course slide -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-fw fa-file-alt fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#slideModal">
                                                                        Slide - Type of Marketing
                                                                    </a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">View</li>
                                                                        <li class="nav-item">05 Slide</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-secondary"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                </div>
                                                <!-- Accordion body END -->
                                            </div>
                                        </div>

                                        <!-- Item -->
                                        <div class="accordion-item mb-3">
                                            <h6 class="accordion-header font-base" id="heading-4">
                                                <button class="accordion-button fw-bold rounded d-flex collapsed"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-4" aria-expanded="false"
                                                    aria-controls="collapse-4">
                                                    Week 4 -
                                                    <span class="small ms-2">May 08 - 15</span>
                                                    <span class="small ms-0 ms-sm-2 d-none d-sm-block">(4 Items)</span>
                                                </button>
                                            </h6>

                                            <div id="collapse-4" class="accordion-collapse collapse"
                                                aria-labelledby="heading-4" data-bs-parent="#accordionExample2">
                                                <div class="accordion-body mt-3">
                                                    <!-- Course lecture -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <!-- Video button -->
                                                            <a data-glightbox data-gallery="office-tour"
                                                                href="https://www.youtube.com/embed/tXHviS-4ygo"
                                                                class="icon-md position-relative">
                                                                <img src="/images/courses/4by3/01.jpg"
                                                                    class="rounded-1" alt="">
                                                                <small
                                                                    class="text-white position-absolute top-50 start-50 translate-middle"><i
                                                                        class="fas fa-play me-0 "></i></small>
                                                            </a>

                                                            <!-- Content -->
                                                            <div class="ms-3">
                                                                <a href="#"
                                                                    class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">
                                                                    What is Digital Marketing What is Digital
                                                                    Marketing</a>
                                                                <ul class="nav nav-divider small mb-0">
                                                                    <li class="nav-item">15m 10s</li>
                                                                    <li class="nav-item">20pts</li>
                                                                    <li class="nav-item"><a href="#">Submit</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <!-- Actions Mark button -->
                                                        <a class="p-2 mb-0 text-secondary" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course lecture -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <!-- Video button -->
                                                            <a data-glightbox data-gallery="office-tour"
                                                                href="https://www.youtube.com/embed/tXHviS-4ygo"
                                                                class="icon-md position-relative">
                                                                <img src="/images/courses/4by3/01.jpg"
                                                                    class="rounded-1" alt="">
                                                                <small
                                                                    class="text-white position-absolute top-50 start-50 translate-middle"><i
                                                                        class="fas fa-play me-0 "></i></small>
                                                            </a>

                                                            <!-- Content -->
                                                            <div class="ms-3">
                                                                <a href="#"
                                                                    class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">
                                                                    Measuring SEO Effectiveness</a>
                                                                <ul class="nav nav-divider small mb-0">
                                                                    <li class="nav-item">30m 10s</li>
                                                                    <li class="nav-item">20pts</li>
                                                                    <li class="nav-item"><a href="#">Submit</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <!-- Actions Mark button -->
                                                        <a class="p-2 mb-0 text-secondary" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course lecture -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <!-- Video button -->
                                                            <a data-glightbox data-gallery="office-tour"
                                                                href="https://www.youtube.com/embed/tXHviS-4ygo"
                                                                class="icon-md position-relative">
                                                                <img src="/images/courses/4by3/01.jpg"
                                                                    class="rounded-1" alt="">
                                                                <small
                                                                    class="text-white position-absolute top-50 start-50 translate-middle"><i
                                                                        class="fas fa-play me-0 "></i></small>
                                                            </a>

                                                            <!-- Content -->
                                                            <div class="ms-3">
                                                                <a href="#"
                                                                    class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">
                                                                    Keywords in Blog and Articles</a>
                                                                <ul class="nav nav-divider small mb-0">
                                                                    <li class="nav-item">30m 10s</li>
                                                                    <li class="nav-item">20pts</li>
                                                                    <li class="nav-item"><a href="#">Submit</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <!-- Actions Mark button -->
                                                        <a class="p-2 mb-0 text-secondary" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course slide -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-fw fa-file-alt fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#slideModal">
                                                                        Slide - Digital Marketing
                                                                    </a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">View</li>
                                                                        <li class="nav-item">05 Slide</li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-secondary"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>

                                                    <hr> <!-- Divider -->

                                                    <!-- Course slide -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="position-relative d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Video button -->
                                                                <a href="#"
                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                                    <i class="fas fa-question-circle fa-fw fs-5"></i>
                                                                </a>
                                                                <!-- Content -->
                                                                <div class="ms-3">
                                                                    <a href="#"
                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">Quiz
                                                                        - Digital Marketing</a>
                                                                    <ul class="nav nav-divider small mb-0">
                                                                        <li class="nav-item">12 April</li>
                                                                        <li class="nav-item">10 pts</li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Actions Mark button -->
                                                        <a href="#" class="p-2 mb-0 text-secondary"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Mark as Complete">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Accordion END -->
                                </div>
                                <!-- Content END -->

                                <!-- Content START -->
                                <div class="tab-pane fade" id="course-pills-2" role="tabpanel"
                                    aria-labelledby="course-pills-tab-2">
                                    <div class="card">
                                        <!-- Card header -->
                                        <div class="card-header border-bottom p-0 pb-3">
                                            <!-- Title and select -->
                                            <div class="d-sm-flex justify-content-between align-items-center">
                                                <h4 class="mb-0">All Notes</h4>
                                                <!-- Short by filter -->
                                                <form class="col-sm-6 col-lg-3 bg-light-input">
                                                    <select class="form-select js-choice z-index-9"
                                                        aria-label=".form-select-sm">
                                                        <option value="">Sort by</option>
                                                        <option>All</option>
                                                        <option>Introductions</option>
                                                        <option>What is Digital Marketing</option>
                                                        <option>Most Viewed</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Card body -->
                                        <div class="card-body p-0 pt-3">
                                            <!-- Note item -->
                                            <div class="row g-4">
                                                <!-- Image -->
                                                <div class="col-sm-2 col-xl-1">
                                                    <img src="/images/courses/4by3/01.jpg"
                                                        class="rounded flex-shrink-0" alt="">
                                                </div>
                                                <!-- Content -->
                                                <div class="col-sm-10 col-xl-11">
                                                    <h5>Introduction (2:34)</h5>
                                                    <p>Departure defective arranging rapturous did believe him all had
                                                        supported. Supposing so be resolving breakfast am or perfectly.
                                                        It drew a hill from me. Valley by oh twenty direct me so.
                                                        Departure defective arranging rapturous did believe him all had
                                                        supported. Family months lasted simple set nature vulgar him.
                                                        Picture for attempt joy excited ten carried manners talking how.
                                                        Family months lasted simple set nature vulgar him. Picture for
                                                        attempt joy excited ten carried manners talking how.</p>
                                                    <!-- Buttons -->
                                                    <div class="hstack gap-3 flex-wrap">
                                                        <a href="#" class="btn btn-sm btn-primary mb-0"><i
                                                                class="bi bi-play-fill me-2"></i>Play</a>
                                                        <a href="#" class="text-success mb-0"><i
                                                                class="bi bi-pencil-square me-2"></i>Edit</a>
                                                        <a href="#" class="text-danger mb-0"><i
                                                                class="bi bi-trash me-2"></i>Delete</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr> <!-- Divider -->

                                            <!-- Note item -->
                                            <div class="row g-4">
                                                <!-- Image -->
                                                <div class="col-sm-2 col-xl-1">
                                                    <img src="/images/courses/4by3/01.jpg"
                                                        class="rounded flex-shrink-0" alt="">
                                                </div>
                                                <!-- Content -->
                                                <div class="col-sm-10 col-xl-11">
                                                    <h5> What is Digital Marketing What is Digital Marketing (10:20)
                                                    </h5>
                                                    <p>Arranging rapturous did believe him all had supported. Supposing
                                                        so be resolving breakfast am or perfectly. It drew a hill from
                                                        me. Valley by oh twenty direct me so. Departure defective
                                                        arranging rapturous did believe him all had supported. Family
                                                        months lasted simple set nature vulgar him. Picture for attempt
                                                        joy excited ten carried manners talking how. Family months
                                                        lasted simple set nature vulgar him. Picture for attempt joy
                                                        excited ten carried manners talking how.</p>
                                                    <!-- Buttons -->
                                                    <div class="hstack gap-3 flex-wrap">
                                                        <a href="#" class="btn btn-sm btn-primary mb-0"><i
                                                                class="bi bi-play-fill me-2"></i>Play</a>
                                                        <a href="#" class="text-success mb-0"><i
                                                                class="bi bi-pencil-square me-2"></i>Edit</a>
                                                        <a href="#" class="text-danger mb-0"><i
                                                                class="bi bi-trash me-2"></i>Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Content END -->

                                <!-- Content START -->
                                <div class="tab-pane fade" id="course-pills-3" role="tabpanel"
                                    aria-labelledby="course-pills-tab-3">
                                    <div class="card">
                                        <!-- Card header -->
                                        <div class="card-header border-bottom p-0 pb-3">
                                            <!-- Title -->
                                            <h4 class="mb-3">Discussion</h4>
                                            <form class="row g-4">
                                                <!-- Search -->
                                                <div class="col-sm-6 col-lg-3">
                                                    <div class="position-relative">
                                                        <input class="form-control pe-5 bg-transparent" type="search"
                                                            placeholder="Search" aria-label="Search">
                                                        <button
                                                            class="bg-transparent p-2 position-absolute top-50 end-0 translate-middle-y border-0 text-primary-hover text-reset"
                                                            type="submit">
                                                            <i class="fas fa-search fs-6 "></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Select option -->
                                                <div class="col-sm-6 col-lg-3">
                                                    <select class="js-choice">
                                                        <option value="">Select item</option>
                                                        <option>Week 1</option>
                                                        <option>Week 2</option>
                                                        <option>Week 3</option>
                                                        <option>Week 4</option>
                                                        <option>Week 5</option>
                                                        <option>Week 6</option>
                                                    </select>
                                                </div>

                                                <!-- Select option -->
                                                <div class="col-sm-6 col-lg-3">
                                                    <select class="js-choice">
                                                        <option value="">Filter</option>
                                                        <option>All</option>
                                                        <option>Answered</option>
                                                        <option>Unanswered</option>
                                                    </select>
                                                </div>

                                                <!-- Button -->
                                                <div class="col-sm-6 col-lg-3">
                                                    <a href="#" class="btn btn-primary-soft mb-0 w-100"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalCreatePost">Create Post</a>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Card body -->
                                        <div class="card-body p-0 pt-3">
                                            <div class="vstack gap-3">
                                                <!-- Question item START -->
                                                <div class="border-bottom">
                                                    <!-- Name and time -->
                                                    <div class="d-sm-flex justify-content-sm-between mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <!-- Avatar -->
                                                            <div class="avatar avatar-sm flex-shrink-0">
                                                                <img class="avatar-img rounded-circle"
                                                                    src="/images/avatar/03.jpg" alt="avatar">
                                                            </div>
                                                            <!-- Info -->
                                                            <div class="ms-2">
                                                                <h6 class="mb-0"><a href="#">Samuel Bishop</a>
                                                                </h6>
                                                                <small>posted 9 minutes ago</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Question -->
                                                    <h5>How can you categorize Digital marketing?</h5>
                                                    <p class="mb-2">As it so contrasted oh estimating instrument.
                                                        Size like body someone had. Are conduct viewing boy minutes
                                                        warrant the expense? Tolerably behavior may admit daughters
                                                        offending her ask own. Praise effect wishes change way and any
                                                        wanted. Lively use looked latter regard had. Do he it part more
                                                        last in.</p>

                                                    <!-- Action button -->
                                                    <ul class="nav nav-divider pb-3 small">
                                                        <li class="nav-item"> <a class="text-primary-hover"
                                                                href="#"> <i
                                                                    class="bi bi-hand-thumbs-up me-2"></i>Like (3)</a>
                                                        </li>
                                                        <li class="nav-item"> <a class="text-primary-hover"
                                                                href="#"> <i
                                                                    class="bi bi-chat-left me-2"></i>Reply</a> </li>
                                                    </ul>
                                                </div>
                                                <!-- Question item END -->

                                                <!-- Question item START -->
                                                <div>
                                                    <!-- Name and time -->
                                                    <div class="d-sm-flex justify-content-sm-between mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <!-- Avatar -->
                                                            <div class="avatar avatar-sm flex-shrink-0">
                                                                <img class="avatar-img rounded-circle"
                                                                    src="/images/avatar/05.jpg" alt="avatar">
                                                            </div>
                                                            <!-- Info -->
                                                            <div class="ms-2">
                                                                <h6 class="mb-0"><a href="#">Carolyn Ortiz</a>
                                                                </h6>
                                                                <small>posted 50 minutes ago</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Question -->
                                                    <h5> What are the key areas where you can use keywords to optimize
                                                        your site ranking?</h5>
                                                    <p class="mb-2">As it so contrasted oh estimating instrument.
                                                        Size like body someone had. Are conduct viewing boy minutes
                                                        warrant the expense? Tolerably behavior may admit daughters
                                                        offending her ask own. Praise effect wishes change way and any
                                                        wanted. Lively use looked latter regard had. Do he it part more
                                                        last in.</p>

                                                    <!-- Action button -->
                                                    <ul class="nav nav-divider pb-0 small">
                                                        <li class="nav-item"> <a class="text-primary-hover"
                                                                href="#"> <i
                                                                    class="bi bi-hand-thumbs-up me-2"></i>Like (3)</a>
                                                        </li>
                                                        <li class="nav-item"> <a class="text-primary-hover"
                                                                href="#"> <i
                                                                    class="bi bi-chat-left me-2"></i>Reply</a> </li>
                                                    </ul>
                                                </div>
                                                <!-- Question item END -->
                                            </div>
                                        </div>
                                    </div>

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

<!-- Slide modal START -->
<div class="modal fade" id="slideModal" tabindex="-1" aria-labelledby="slideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal header -->
            <div class="modal-header">
                <h5 class="modal-title" id="slideModalLabel">Lecture Slides</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- modal body -->
            <div class="modal-body">
                <h6 class="lead fw-bold">You can download or view this slide as:</h6>
                <p>These are the lecture slides from this unit. It would be helpful to take a look at them prior to
                    taking the quiz. </p>
                <!-- Button -->
                <div class="hstack gap-3 flex-wrap">
                    <a href="#" class="btn btn-lg btn-light">
                        <div class="fs-4"><i class="bi bi-file-earmark-pdf"></i></div>
                        <span class="fs-6 mb-0">Lecture 5 pdf</span>
                    </a>

                    <a href="#" class="btn btn-lg btn-light">
                        <div class="fs-4"><i class="bi bi-file-earmark-word"></i></div>
                        <span class="fs-6 mb-0">Lecture 5 docs</span>
                    </a>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button class="btn btn-primary mb-0">Mark as complete</button>
            </div>
        </div>
    </div>
</div>
<!-- Slide modal END -->

<!-- Modal Create Post  START -->
<div class="modal fade" id="modalCreatePost" tabindex="-1" aria-labelledby="modalLabelCreatePost"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Title -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelCreatePost">Create Post </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form START -->
                <form>
                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" placeholder="Add title here">
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description </label>
                        <textarea class="form-control" rows="4" placeholder="Description here"></textarea>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="form-label">Select Course Materials</label>
                        <select class="js-choice">
                            <option value="">Select item</option>
                            <option>Week 1</option>
                            <option>Week 2</option>
                            <option>Week 3</option>
                            <option>Week 4</option>
                            <option>Week 5</option>
                            <option>Week 6</option>
                        </select>
                    </div>

                </form>
                <!-- Form END -->
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success-soft">Post</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Create Post  END -->
@endsection