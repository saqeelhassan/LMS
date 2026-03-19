@extends('DSIMT-Webiste.layout')

@section('content')


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Course List One</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Courses start (LMS backend: active courses) -->
    <section class="courses">
      <div class="container">
        <div class="wrap-customize">
          <div class="row">
            @forelse($courses as $course)
            <div class="col-lg-4 col-md-6 customize-wrap mb-4 wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <img src="{{ $course->image_url }}" alt="{{ $course->name }}" />
                </div>
                <div class="customize-ct">
                  <h4>
                    <a href="{{ route('dsimt.course.detail', $course) }}">{{ $course->name }}</a>
                  </h4>
                  <div class="review-ct d-flex justify-content-start">
                    <a href="{{ route('dsimt.course.detail', $course) }}">{{ $course->enrollments_count }} {{ Str::plural('Enrollment', $course->enrollments_count) }}</a>
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
                    <li><i class="far fa-user"></i> {{ $course->instructor->name ?? '—' }}</li>
                    <li><i class="far fa-clock"></i> {{ $course->total_hours ?? '—' }}</li>
                    <li><i class="far fa-star"></i> <a href="{{ route('dsimt.course.detail', $course) }}" class="text-reset">View Details</a></li>
                  </ul>
                </div>
              </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
              <p class="text-body-secondary">No courses available at the moment. Check back later.</p>
            </div>
            @endforelse
          </div>
          @if($courses->hasPages())
          <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
              {{ $courses->links() }}
            </div>
          </div>
          @endif
        </div>
      </div>
    </section>
    <!-- Courses ends -->

    <!--  Call to action start -->
    <section class="call-action p-0 wow fadeInUp">
      <div class="container">
        <div class="call-wrap">
          <div class="call-main">
            <h3 class="mb-4">JOIN THE COMMUNITY COURSE AND <span class="cl-blue"> UPGRADE YOUR SKILL</span></h3>
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
