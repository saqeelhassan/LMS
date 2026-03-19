@extends('DSIMT-Webiste.layout')

@section('content')

    {{-- Breadcrumb: Courses page header --}}
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Courses</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>

    @php
      /* Always use /courses/detail/{id} for course links on the website */
      $courseDetailRoute = 'website.courses.detail';
    @endphp
    {{-- Start of Dynamic Course Grid (LMS backend: active courses) --}}
    <section class="courses">
      <div class="container">
        <div class="wrap-customize">
          <div class="row">
            @foreach($courses as $course)
            <div class="col-lg-4 col-md-6 customize-wrap mb-4 wow fadeInUp">
              <div class="customize-item">
                {{-- Thumbnail: from LMS (uploaded image or placeholder) --}}
                <div class="sv-image">
                  <a href="{{ route($courseDetailRoute, ['course' => $course]) }}">
                    <img src="{{ $course->image_url }}" alt="{{ $course->name }}" />
                  </a>
                </div>
                <div class="customize-ct">
                  {{-- Title (course name from LMS) --}}
                  <h4>
                    <a href="{{ route($courseDetailRoute, ['course' => $course]) }}">{{ $course->name }}</a>
                  </h4>
                  {{-- Category (course mode), price placeholder; enrollments count --}}
                  <div class="review-ct d-flex justify-content-start">
                    <a href="{{ route($courseDetailRoute, ['course' => $course]) }}">{{ $course->enrollments_count }} {{ Str::plural('Enrollment', $course->enrollments_count) }}</a>
                    @if($course->courseMode)
                    <span class="ms-2 text-muted small">{{ $course->courseMode->name }}</span>
                    @endif
                    <ul class="ml-2">
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star-half-alt"></i></li>
                    </ul>
                  </div>
                  {{-- Price: LMS has no price field; show "Contact for price" --}}
                  <p class="small mb-0 mt-1 text-body">Contact for price</p>
                  {{-- View button: go to course detail --}}
                  <a href="{{ route($courseDetailRoute, ['course' => $course]) }}" class="btn btn-sm btn-primary mt-2">View</a>
                </div>
                <div class="customize-bottom">
                  <ul class="d-flex justify-content-between">
                    <li><i class="far fa-user"></i> {{ $course->instructor->name ?? '—' }}</li>
                    <li><i class="far fa-clock"></i> {{ $course->total_hours ?? '—' }}</li>
                    <li><i class="far fa-star"></i> <a href="{{ route($courseDetailRoute, ['course' => $course]) }}" class="text-reset">View Details</a></li>
                  </ul>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          {{-- Empty state: when no active courses --}}
          @if($courses->isEmpty())
          <div class="row">
            <div class="col-12 text-center py-5">
              <p class="text-body-secondary mb-0">No courses available at the moment. Check back later.</p>
            </div>
          </div>
          @endif
        </div>
      </div>
    </section>
    {{-- End of Dynamic Course Grid --}}

    {{-- Call to action --}}
    <section class="call-action p-0 wow fadeInUp">
      <div class="container">
        <div class="call-wrap">
          <div class="call-main">
            <h3 class="mb-4">JOIN THE COMMUNITY COURSE AND <span class="cl-blue"> UPGRADE YOUR SKILL</span></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
          </div>
          <div class="call-btn">
            <a href="{{ route('dsimt.contact') }}" class="btn">Join Now</a>
          </div>
        </div>
      </div>
    </section>

    {{-- Newsletter --}}
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

@endsection
