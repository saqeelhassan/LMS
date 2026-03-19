@extends('DSIMT-Webiste.layout')

@section('content')


    <!-- Course Detail start -->
    <section class="course-detail shape_big2">
      <div class="container">
        <div class="row pb-5">
          <div class="col-lg-6">
            <div class="cs-detail-im">
              <img src="{{ $course->image_url }}" alt="{{ $course->name }}" />
            </div>
          </div>
          <div class="col-lg-6">
            <div class="cs-detail-info d-flex flex-column justify-content-center align-items-start h-100">
              <div class="review-ct mb-3 d-flex justify-content-start">
                <a href="#">{{ $course->enrollments_count }} {{ Str::plural('Enrollment', $course->enrollments_count) }}</a>
                @if($course->courseMode)
                <span class="ms-2 badge bg-primary">{{ $course->courseMode->name }}</span>
                @endif
                <ul class="ml-2">
                  <li><i class="fas fa-star"></i></li>
                  <li><i class="fas fa-star"></i></li>
                  <li><i class="fas fa-star"></i></li>
                  <li><i class="fas fa-star"></i></li>
                  <li><i class="fas fa-star-half-alt"></i></li>
                </ul>
              </div>
              <h3>{{ $course->name }}</h3>
              <div class="customize-bottom">
                <ul class="d-flex justify-content-start">
                  <li class="mr-3"><i class="far fa-user"></i> {{ $course->instructor->name ?? '—' }}</li>
                  <li><i class="far fa-calendar-alt"></i> {{ $course->release_date ? $course->release_date->format('d M, Y') : ($course->created_at ? $course->created_at->format('d M, Y') : '—') }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="course-content">
              <div class="cs-title">
                <h3>course overview</h3>
              </div>
              <div class="cs-contents">
                @if($course->description)
                  <div class="course-description">{!! nl2br(e($course->description)) !!}</div>
                @else
                  <p class="text-muted">No description available yet.</p>
                @endif
                <div class="cs-title mt-4">
                  <h3>Curriculum</h3>
                </div>

                <!--Accordion wrapper-->
                <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">
                  <!-- Accordion card -->
                  <div class="card">
                    <!-- Card header -->
                    <div class="card-header" role="tab" id="headingTwo1">
                      <a
                        class="collapsed"
                        data-toggle="collapse"
                        data-parent="#accordionEx1"
                        href="#collapseTwo1"
                        aria-expanded="false"
                        aria-controls="collapseTwo1"
                      >
                        <h5 class="mb-0">READING <i class="fas fa-plus"></i></h5>
                      </a>
                    </div>

                    <!-- Card body -->
                    <div id="collapseTwo1" class="collapse" role="tabpanel" aria-labelledby="headingTwo1" data-parent="#accordionEx1">
                      <div class="card-body">
                        Ut enim ad minim veniamLorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar
                        dapibus leo.
                      </div>
                    </div>
                  </div>
                  <!-- Accordion card -->

                  <!-- Accordion card -->
                  <div class="card">
                    <!-- Card header -->
                    <div class="card-header" role="tab" id="headingTwo21">
                      <a
                        class="collapsed"
                        data-toggle="collapse"
                        data-parent="#accordionEx1"
                        href="#collapseTwo21"
                        aria-expanded="false"
                        aria-controls="collapseTwo21"
                      >
                        <h5 class="mb-0">GREETING AND INTRODUCTION <i class="fas fa-plus"></i></h5>
                      </a>
                    </div>

                    <!-- Card body -->
                    <div id="collapseTwo21" class="collapse" role="tabpanel" aria-labelledby="headingTwo21" data-parent="#accordionEx1">
                      <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                      </div>
                    </div>
                  </div>
                  <!-- Accordion card -->

                  <!-- Accordion card -->
                  <div class="card">
                    <!-- Card header -->
                    <div class="card-header" role="tab" id="headingThree31">
                      <a
                        class="collapsed"
                        data-toggle="collapse"
                        data-parent="#accordionEx1"
                        href="#collapseThree31"
                        aria-expanded="false"
                        aria-controls="collapseThree31"
                      >
                        <h5 class="mb-0">AUDIO: INTERACTIVE LESSON <i class="fas fa-plus"></i></h5>
                      </a>
                    </div>

                    <!-- Card body -->
                    <div id="collapseThree31" class="collapse" role="tabpanel" aria-labelledby="headingThree31" data-parent="#accordionEx1">
                      <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                      </div>
                    </div>
                  </div>
                  <!-- Accordion card -->

                  <!-- Accordion card -->
                  <div class="card">
                    <!-- Card header -->
                    <div class="card-header" role="tab" id="headingThree41">
                      <a
                        class="collapsed"
                        data-toggle="collapse"
                        data-parent="#accordionEx1"
                        href="#collapseThree41"
                        aria-expanded="false"
                        aria-controls="collapseThree41"
                      >
                        <h5 class="mb-0">READING: UT ENIM AD MINIM VENIAM <i class="fas fa-plus"></i></h5>
                      </a>
                    </div>

                    <!-- Card body -->
                    <div id="collapseThree41" class="collapse" role="tabpanel" aria-labelledby="headingThree41" data-parent="#accordionEx1">
                      <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                      </div>
                    </div>
                  </div>
                  <!-- Accordion card -->
                </div>
                <!-- Accordion wrapper -->

                <div class="mt-5">
                  <a href="{{ !empty($useDsimtDetailUrl) ? route('dsimt.course') : route('website.courses') }}" class="btn btn-outline-primary"><i class="fas fa-angle-double-left me-1"></i> Back to Courses</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="course-content-side text-center">
              <img src="{{ $course->image_url }}" alt="{{ $course->name }}" class="img-fluid" />
              <div class="img_sidebar_ct bg-darkblue p-3">
                <h5 class="cl-white mb-0">Contact for price</h5>
              </div>
              <ul class="d-flex flex-column text-start">
                <li><i class="far fa-building"></i> Instructor : <span>{{ $course->instructor->name ?? '—' }}</span></li>
                <li><i class="fas fa-book"></i> Lectures : <span>{{ $course->total_lectures ?? '—' }}</span></li>
                <li><i class="fas fa-user-friends"></i> Enrolled : <span>{{ $course->enrollments_count }} {{ Str::plural('student', $course->enrollments_count) }}</span></li>
                <li><i class="far fa-clock"></i> Duration : <span>{{ $course->total_hours ?? '—' }}</span></li>
                <li><i class="fas fa-globe-europe"></i> Language : <span>{{ $course->language ?? '—' }}</span></li>
              </ul>
              <a href="{{ route('dsimt.contact') }}" class="btn">Enroll Now</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Courses Detail end -->

    @php $courseDetailRoute = !empty($useDsimtDetailUrl) ? 'dsimt.course.detail' : 'website.courses.detail'; @endphp
    @if(isset($relatedCourses) && $relatedCourses->isNotEmpty())
    <!-- Related Courses -->
    <section class="courses p-0">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline">
          <div class="title-top">
            <div class="title-quote">
              <span>Related Courses</span>
            </div>
            <h2>BROWSE ONLINE RELATED <span class="cl-blue">COURSE</span></h2>
          </div>
        </div>
        <div class="wrap-customize">
          <div class="row">
            @foreach($relatedCourses as $related)
            <div class="col-lg-4 col-md-6 customize-wrap wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <a href="{{ route($courseDetailRoute, $related) }}"><img src="{{ $related->image_url }}" alt="{{ $related->name }}" /></a>
                </div>
                <div class="customize-ct">
                  <h4>
                    <a href="{{ route($courseDetailRoute, $related) }}">{{ $related->name }}</a>
                  </h4>
                  <div class="review-ct d-flex justify-content-start">
                    <a href="{{ route($courseDetailRoute, $related) }}">{{ $related->enrollments_count }} Enrollments</a>
                    <ul class="ml-2">
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star-half-alt"></i></li>
                    </ul>
                  </div>
                </div>
                <div class="customize-bottom">
                  <ul class="d-flex justify-content-between">
                    <li><i class="far fa-user"></i> {{ $related->instructor->name ?? '—' }}</li>
                    <li><i class="far fa-clock"></i> {{ $related->total_hours ?? '—' }}</li>
                    <li><i class="far fa-star"></i> {{ $related->enrollments_count }} enrolled</li>
                  </ul>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>
    @endif
    <!-- Courses ends -->

    <!--  Call to action start -->
    <section class="call-action pb-0 wow fadeInUp">
      <div class="container">
        <div class="call-wrap">
          <div class="call-main">
            <h2 class="mb-4">JOIN THE COMMUNITY COURSE AND <span class="cl-blue"> UPGRADE YOUR SKILL</span></h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
          </div>
          <div class="call-btn">
            <a href="contact.html" class="btn">Join Now</a>
          </div>
        </div>
      </div>
    </section>
    <!--  Call to action end -->

    <!--  Newsletter start -->
    <section class="newsletter">
      <div class="container">
        <div class="news-headding text-center">
          <h2>SIGN UP TO OUR NEWSLETTER</h2>
          <p>
            Subscribe to our newsletter and get many <br />
            interesting things every week
          </p>
          <form>
            <div class="form-group">
              <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Your Email" />
              <button class="btn"><i class="fas fa-envelope-open-text"></i> Subscribe</button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!--  Newsletter end -->

@endsection
