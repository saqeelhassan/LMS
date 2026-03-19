@extends('DSIMT-Webiste.layout')

@section('content')
{{-- Start of DSIMT Home Page - Banner, services, courses, events, team, blog. --}}

    <!-- banner starts - AI-generated images from dsimt-assets/images/carouser -->
    <section class="home-3 banner-main banner-3 pb-0">
      <div class="banner-content">
        <div class="slider banner-slider">
          <div
            class="h2-slider-list"
            style="background-image: url({{ asset('dsimt-assets/images/carouser/1.jpg') }}); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 420px;"
          >
            <div class="container">
              <div class="slide-contain text-left wow fadeInUp">
                <h1 class="banner-headline">Begin your journey towards professionalism today.</h1>
                <h2 class="banner-subhead">Real Technologist Producer</h2>
                <p class="banner-desc">Cutting-edge tech production service. We create and deliver innovative solutions and content for a dynamic digital landscape.</p>
                <div class="slide-btn">
                  <a href="{{ route('dsimt.course') }}" class="btn">Enroll Now</a>
                  <a href="{{ route('dsimt.course') }}" class="btn btn-outline-light">Our Courses</a>
                </div>
              </div>
            </div>
            <div class="sl-overlay"></div>
          </div>
          <div class="h2-slider-list" style="background-image: url({{ asset('dsimt-assets/images/carouser/2.jpg') }}); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 420px;">
            <div class="container">
              <div class="slide-contain text-left wow fadeInUp">
                <h1 class="banner-headline">Start coding your way to success today!</h1>
                <h2 class="banner-subhead">Innovation Paradise <span class="d-block">For Students</span></h2>
                <p class="banner-desc">We empower students by cultivating excellence, ensuring they thrive in an environment that encourages creative thinking, problem-solving, and groundbreaking ideas.</p>
                <div class="slide-btn">
                  <a href="{{ route('dsimt.course') }}" class="btn">Enroll Now</a>
                  <a href="{{ route('dsimt.contact') }}" class="btn btn-outline-light">Our Services</a>
                </div>
              </div>
            </div>
            <div class="sl-overlay"></div>
          </div>
          <div class="h2-slider-list" style="background-image: url({{ asset('dsimt-assets/images/carouser/3.jpg') }}); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 420px;">
            <div class="container">
              <div class="slide-contain text-left wow fadeInUp">
                <h1 class="banner-headline">Begin your journey towards IT excellence now!</h1>
                <h2 class="banner-subhead">Your Ideas Will Be<br>Heard & Supported</h2>
                <p class="banner-desc">Join a creative workplace that actively supports and empowers your ideas, providing resources to turn them into impactful innovations.</p>
                <div class="slide-btn">
                  <a href="{{ route('dsimt.course') }}" class="btn">Enroll Now</a>
                  <a href="{{ route('dsimt.instructors') }}" class="btn btn-outline-light">Our Experienced Team</a>
                </div>
              </div>
            </div>
            <div class="sl-overlay"></div>
          </div>
        </div>
      </div>
    </section>
    <!-- banner ends -->

    <!-- content main start -->
    <section class="home-3 services-main pb-0">
      <div class="container">
        <div class="service-full wow fadeInRight">
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-6 col-md-12 pr-lg-0 wow fadeInLeftBig">
                  <div class="serv-wrap-img">
                    <img src="{{ asset('dsimt-assets/images/') }}inner/girl-doing-homework-or-online-education-2021-04-05-10-57-55-utc.jpg" alt="" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-12 pl-lg-0 wow fadeInRightBig">
                  <div class="serv-us-wrap d-flex flex-column justify-content-center">
                    <div class="serv-title">
                      <h2 class="top-title mb-3">Since 2020
                      Trusted IT training for modern skills.</h2>
                      <!-- <h2 class="mb-3 pb-3 cl-white">APPLY FOR ADMISSION</h2> -->
                    </div>
                    <div class="serv-content">
                      <p class="cl-white">
                      Welcome to Digital Sindh Institute of Management & Technology (DSIMT), a trusted IT training institute in Hyderabad, Sindh. We offer practical, career-focused IT courses designed to help students and professionals build real-world skills. Whether you're starting your journey or upgrading your expertise, DSIMT is here to support your success.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12 col-md-12">
              <div class="row service-list-wrap">
                <div class="col-lg-3 col-md-6 pr-0">
                  <div class="service-ct-list bg-scblue">
                    <!-- <i class="far fa-user"></i> -->
                    <div class="serv-list text-left">
                      <h4 class="cl-white mb-0"><img src="{{ asset('dsimt-assets/images/logo/logo.png') }}" alt="DSIMT" class="dsimt-logo-inline">DSIMT</h4>
                      <span>Overall in here</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 p-0">
                  <div class="service-ct-list bg-scgreen">
                    <!-- <i class="fas fa-book-open"></i> -->
                    <div class="serv-list text-left">
                      <h4 class="cl-white mb-0"><img src="{{ asset('dsimt-assets/images/logo/pitp.png') }}" alt="PITP" class="dsimt-logo-inline">People's IT Program</h4>
                      <span>Getting Diploma</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 p-0">
                  <div class="service-ct-list bg-sc-lblue">
                    <!-- <i class="fas fa-globe-americas"></i> -->
                    <div class="serv-list text-left">
                      <h4 class="cl-white mb-0"><img src="{{ asset('dsimt-assets/images/logo/bbsh.png') }}" alt="BBS" class="dsimt-logo-inline">BBSSHRRDB</h4>
                      <span>Certified Teachers</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 pl-0">
                  <div class="service-ct-list bg-sc-dblue">
                    <!-- <i class="fas fa-book"></i> -->
                    <!-- <div class="serv-list text-left"> -->
                      <h4 class="cl-white mb-0"><img src="{{ asset('dsimt-assets/images/logo/navtac.png') }}" alt="NAVTAC" class="dsimt-logo-inline">BBSSHRRDB</h4>
                      <span>Overall In Here</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End content main -->

    <!-- About start -->
    <section class="home-3 about-company">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-12 wow fadeInLeftBig">
            <div class="about-wrap-img d-flex flex-column justify-content-center h-100">
              <img src="{{ asset('dsimt-assets/images/') }}logo-w.png" alt="" />
              <h2 class="cl-blue">ABOUT OUR DSIMT</h2>
            </div>
          </div>
          <div class="col-lg-7 col-md-12 wow fadeInRightBig">
            <div class="about-us-wrap">
              <div class="about-title-n">
                <h4 class="top-title">Welcome to DSIMT,the leading and best IT training institute in Hyderabad, Sindh.</h4>
              </div>
              <div class="about-content">
                <p>Looking for a trusted and result-driven IT training institute in Hyderabad, Sindh? Digital Sindh Institute of Management & Technology (DSIMT) offers modern, career-focused IT education designed for today’s digital world.</p>
                <p>
                We provide industry-relevant courses that help students and professionals develop practical skills and real-world experience for better career opportunities. 
                </p>
                <p class="mb-4">
                Whether you are a beginner or upgrading your skills, our flexible training programs help you learn, grow, and succeed.</p>
                <a href="about.php" class="btn">Learn More</a>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="counter">
              <div class="counter-wrap wow fadeInUp">
                <div class="content d-flex justify-content-between">
                  <div class="value-pin">
                    <span class="countfect value" data-num="233"></span>
                    <h5>COURSES & VIDEOS</h5>
                  </div>
                  <div class="value-pin">
                    <span class="countfect value" data-num="410"></span>
                    <h5>EXPERT TEACHERS</h5>
                  </div>
                  <div class="value-pin">
                    <span class="countfect value" data-num="2299"></span>
                    <h5>TOTAL STUDENTS</h5>
                  </div>
                  <div class="value-pin">
                    <span class="countfect value" data-num="368"></span>
                    <h5>CLASSES COMPLETE</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- About end -->

    <!-- Browse start -->
    <section class="browse-main p-0">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline">
          <div class="title-top">
            <div class="title-quote">
              <span>Browse Categories</span>
            </div>
            <h2>BROWSE ONLINE COURSE <span class="cl-blue">Categories</span></h2>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
          <div class="browse-list">
            <a href="course-2.html">
              <i class="far fa-chart-bar"></i>
              <h4>Computer Basics</h4>
            </a>
          </div>
          <div class="browse-list">
            <a href="course-2.html">
              <i class="fas fa-video"></i>
              <h4>Programming & Development</h4>
            </a>
          </div>
          <div class="browse-list">
            <a href="course-2.html">
              <i class="fas fa-tools"></i>
              <h4>Graphic & Multimedia</h4>
            </a>
          </div>
          <div class="browse-list">
            <a href="course-2.html">
              <i class="fas fa-brush"></i>
              <h4>Digital Marketing</h4>
            </a>
          </div>
          <div class="browse-list">
            <a href="course-2.html">
              <i class="far fa-lightbulb"></i>
              <h4>Professional Skills</h4>
            </a>
          </div>
        </div>
        <div class="course-bse">
          <div class="d-flex align-items-center justify-content-center">
            <div class="course-b-list">
              <h4 class="cl-blue">Business Foundation Ideas</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            </div>
            <div class="course-b-list bg-darkblue">
              <h4 class="cl-blue">GRADUATED & PROFESSIONAL</h4>
              <p>"Learn the basics of entrepreneurship. Our course helps you build smart business strategies and grow confidently as a young entrepreneur."</p>
            </div>
            <div class="course-b-list">
              <h4 class="cl-blue">Industry-Level Training</h4>
              <p>"Gain practical, job-ready skills through real-world projects. Our hands-on training bridges the gap between classroom learning and professional success."</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Browse end -->

    <!-- Courses start (LMS backend: one-row slider, theme UI) -->
    <section class="courses">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline">
          <div class="title-top">
            <div class="title-quote">
              <a href="{{ route('dsimt.course') }}" class="text-decoration-none"><span>Find More Courses</span></a>
            </div>
            <h2><a href="{{ route('dsimt.course') }}" class="text-decoration-none text-dark">ALL COURSES OF EPATHSHALA</a></h2>
          </div>
        </div>
        <div class="wrap-customize position-relative">
          @if($courses->isNotEmpty())
          <div class="swiper course-home-slider">
            <div class="swiper-wrapper">
              @foreach($courses as $course)
              <div class="swiper-slide">
                <div class="customize-wrap wow fadeInUp">
                  <div class="customize-item">
                    <div class="sv-image">
                      <img src="{{ $course->image_url }}" alt="{{ $course->name }}" />
                    </div>
                    <div class="customize-ct">
                      <h4>
                        <a href="{{ route('website.courses.detail', $course) }}">{{ $course->name }}</a>
                      </h4>
                      <div class="review-ct d-flex justify-content-start">
                        <a href="{{ route('website.courses.detail', $course) }}">{{ $course->enrollments_count }} {{ Str::plural('Enrollment', $course->enrollments_count) }}</a>
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
                        <li><i class="far fa-star"></i> <a href="{{ route('website.courses.detail', $course) }}" class="text-reset">View Details</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            <div class="swiper-button-prev course-home-slider-prev"></div>
            <div class="swiper-button-next course-home-slider-next"></div>
            <div class="swiper-pagination course-home-slider-pagination"></div>
          </div>
          @else
          <div class="row">
            <div class="col-12 text-center py-4">
              <p class="text-body-secondary mb-0">No courses available yet.</p>
              <a href="{{ route('dsimt.course') }}" class="btn btn-primary mt-2">View Courses</a>
            </div>
          </div>
          @endif
          <div class="text-center mt-4">
            <a href="{{ route('dsimt.course') }}" class="btn btn-primary">View All Courses</a>
          </div>
        </div>
      </div>
    </section>
    <!-- Courses ends -->

    @if($courses->isNotEmpty())
    <style>
      /* Course slider: Swiper container (theme-compatible) */
      .course-home-slider {
        position: relative;
        overflow: hidden;
        margin-left: auto;
        margin-right: auto;
        list-style: none;
        padding: 0;
        z-index: 1;
        padding-left: 40px;
        padding-right: 40px;
      }
      .course-home-slider .swiper-wrapper {
        display: flex;
        position: relative;
        width: 100%;
        height: 100%;
        z-index: 1;
        transition-property: transform;
        box-sizing: content-box;
      }
      .course-home-slider .swiper-slide {
        flex-shrink: 0;
        width: 100%;
        height: auto;
        position: relative;
        transition-property: transform;
      }
      .course-home-slider .customize-wrap {
        height: 100%;
        margin-bottom: 0;
      }
      .course-home-slider .customize-item {
        height: 100%;
        display: flex;
        flex-direction: column;
      }
      .course-home-slider .customize-item .sv-image {
        flex-shrink: 0;
        overflow: hidden;
        position: relative;
      }
      .course-home-slider .customize-item .sv-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
      }
      .course-home-slider .customize-item .customize-ct {
        flex: 1;
        margin: 15px 0;
      }
      .course-home-slider .customize-item .customize-ct h4 {
        font-size: 1rem;
        line-height: 1.35;
      }
      .course-home-slider .customize-item .customize-bottom {
        flex-shrink: 0;
      }
      /* Nav buttons: visible and outside content */
      .course-home-slider .course-home-slider-prev,
      .course-home-slider .course-home-slider-next {
        position: absolute;
        top: 50%;
        margin-top: -22px;
        width: 44px;
        height: 44px;
        z-index: 10;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        color: #06bbcc;
        border-radius: 50%;
        box-shadow: 0 2px 12px rgba(0,0,0,0.12);
        transition: background 0.2s, color 0.2s;
      }
      .course-home-slider .course-home-slider-prev:hover,
      .course-home-slider .course-home-slider-next:hover {
        background: #06bbcc;
        color: #fff;
      }
      .course-home-slider .course-home-slider-prev {
        left: 0;
      }
      .course-home-slider .course-home-slider-next {
        right: 0;
      }
      .course-home-slider .course-home-slider-prev::after,
      .course-home-slider .course-home-slider-next::after {
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 18px;
      }
      .course-home-slider .course-home-slider-prev::after {
        content: '\f104';
      }
      .course-home-slider .course-home-slider-next::after {
        content: '\f105';
      }
      /* Pagination below slider */
      .course-home-slider .course-home-slider-pagination {
        position: relative;
        margin-top: 20px;
        bottom: auto !important;
      }
      .course-home-slider .course-home-slider-pagination .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #ccc;
        opacity: 1;
      }
      .course-home-slider .course-home-slider-pagination .swiper-pagination-bullet-active {
        background: #06bbcc;
      }
      @media (max-width: 767px) {
        .course-home-slider {
          padding-left: 28px;
          padding-right: 28px;
        }
        .course-home-slider .course-home-slider-prev,
        .course-home-slider .course-home-slider-next {
          width: 36px;
          height: 36px;
          margin-top: -18px;
        }
        .course-home-slider .course-home-slider-prev::after,
        .course-home-slider .course-home-slider-next::after {
          font-size: 14px;
        }
      }
    </style>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper !== 'undefined' && document.querySelector('.course-home-slider')) {
          new Swiper('.course-home-slider', {
            loop: true,
            slidesPerView: 3,
            spaceBetween: 24,
            grabCursor: true,
            navigation: {
              nextEl: '.course-home-slider-next',
              prevEl: '.course-home-slider-prev'
            },
            pagination: {
              el: '.course-home-slider-pagination',
              clickable: true
            },
            breakpoints: {
              320: { slidesPerView: 1, spaceBetween: 16 },
              576: { slidesPerView: 2, spaceBetween: 20 },
              992: { slidesPerView: 3, spaceBetween: 24 }
            }
          });
        }
      });
    </script>
    @endif

    <!-- Join now start -->
    <section class="join-now">
      <div class="container">
        <div class="row join-wrap">
          <div class="col-lg-7">
            <div class="join-content">
              <h3 class="cl-white">JOIN THE COMMUNITY COURSE AND <span class="cl-blue">UPGRADE YOUR SKILL</span></h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
              </p>
              <a href="contact.html" class="btn mt-2">Join Now</a>
            </div>
          </div>
          <div class="col-lg-5">
            <img src="{{ asset('dsimt-assets/images/') }}inner/friends-studying-in-the-park-2021-04-02-20-21-17-utc.jpg" alt="" />
          </div>
        </div>
      </div>
    </section>
    <!-- Join now end -->

    <!-- News/Events news start -->
    <section class="home-3 courses news-events">
      <div class="container">
        <div class="section-title sc-center borderline">
          <div class="title-top">
            <h2>UPCOMING EVENTS & COMPETITIONS</h2>
            <p>Online learning offers a new way to explore subjects you’re passionate about.</p>
          </div>
          <a href="event.html" class="btn">Read More</a>
        </div>
        <div class="wrap-customize">
          <div class="row">
            <div class="col-lg-4 col-md-6 customize-wrap wow fadeInUp">
              <div class="customize-item d-flex mb-3">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-1.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">THE NEXT GENERATION OF BUSINESS LEADERS</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
              <div class="customize-item d-flex mb-3">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/course-2.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">EPATHSHALA’S ALUMNI HOT AIR BALLON TRIP IN TURKEY</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
              <div class="customize-item d-flex mb-3">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/course-3.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">EPATHSHALA’S ALUMNI HOT AIR BALLON TRIP IN TURKEY</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
              <div class="customize-item d-flex">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/course-4.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">REUNION EVENT: EPATHSHALA’S ALUMNI GOLF TOUR</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 customize-wrap wow fadeInUp">
              <div class="customize-item d-flex mb-3">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/course-2.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">EPATHSHALA’S ALUMNI HOT AIR BALLON TRIP IN TURKEY</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
              <div class="customize-item d-flex mb-3">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-1.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">THE NEXT GENERATION OF BUSINESS LEADERS</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
              <div class="customize-item d-flex mb-3">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/course-4.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">REUNION EVENT: EPATHSHALA’S ALUMNI GOLF TOUR</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
              <div class="customize-item d-flex">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/course-3.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">EPATHSHALA’S ALUMNI HOT AIR BALLON TRIP IN TURKEY</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 customize-wrap wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-3.jpg" alt="" />
                </div>
                <div class="customize-ct">
                  <h5>
                    <a href="#">Donation helps us</a>
                  </h5>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</p>
                  <button class="btn mt-3">Become a Doctor</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- News/Events news start -->

    <!-- Our Team start -->
    <section class="home-3 instructors">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline">
          <div class="title-top">
            <div class="title-quote tq-white">
              <span>Meet Our Team</span>
            </div>
            <h2 class="cl-white">MEET OUR <span class="cl-blue">TEAM</span></h2>
          </div>
        </div>
        <div class="row instruct-main mb-3 wow fadeInLeft">
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="ins-main-list">
              <img src="{{ asset('dsimt-assets/images/') }}team/team-1.jpg" alt="" />
              <div class="ins-names">
                <h4>William Smith</h4>
                <span class="cl-orange">CEO / Founder</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="ins-main-list">
              <img src="{{ asset('dsimt-assets/images/') }}team/team-2.jpg" alt="" />
              <div class="ins-names">
                <h4>Nicole Kiyl</h4>
                <span class="cl-orange">Project Manager</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="ins-main-list">
              <img src="{{ asset('dsimt-assets/images/') }}team/team-3.jpg" alt="" />
              <div class="ins-names">
                <h4>John Melton</h4>
                <span class="cl-orange">Instructor</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="ins-main-list">
              <img src="{{ asset('dsimt-assets/images/') }}team/team-4.jpg" alt="" />
              <div class="ins-names">
                <h4>Ketti Helson</h4>
                <span class="cl-orange">Business Analyst</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Our Team ends -->

    <!-- Testimonial feedback -->
    <section class="testimonial">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline">
          <div class="title-top">
            <div class="title-quote">
              <span>Customers reviews</span>
            </div>
            <h2>WHAT PEOPLE <span class="cl-blue">SAY</span></h2>
          </div>
        </div>
        <div class="row review-slider feedback-main wow fadeInUp">
          <div class="col-md-6">
            <div class="feedback-inner">
              <div class="consult-content">
                <p class="mb-0">
                  I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec
                  ullamcorper mattis, pulvinar dapibus leo.
                </p>
              </div>
              <div class="consult-title mt-3 d-flex justify-content-start">
                <img src="{{ asset('dsimt-assets/images/') }}team/user-1.jpg" alt="" />
                <div class="ps-name">
                  <h5 class="mb-0">Adam Cheis</h5>
                  <span class="cl-orange">Graphic Designer</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="feedback-inner">
              <div class="consult-content">
                <p class="mb-0">
                  I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec
                  ullamcorper mattis, pulvinar dapibus leo.
                </p>
              </div>
              <div class="consult-title mt-3 d-flex justify-content-start">
                <img src="{{ asset('dsimt-assets/images/') }}team/user-2.jpg" alt="" />
                <div class="ps-name">
                  <h5 class="mb-0">Amanda Lee</h5>
                  <span class="cl-orange">CEO & Founder Crix</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="feedback-inner">
              <div class="consult-content">
                <p class="mb-0">
                  I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec
                  ullamcorper mattis, pulvinar dapibus leo.
                </p>
              </div>
              <div class="consult-title mt-3 d-flex justify-content-start">
                <img src="{{ asset('dsimt-assets/images/') }}team/user-1.jpg" alt="" />
                <div class="ps-name">
                  <h5 class="mb-0">Adam Cheis</h5>
                  <span class="cl-orange">Graphic Designer</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="feedback-inner">
              <div class="consult-content">
                <p class="mb-0">
                  I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec
                  ullamcorper mattis, pulvinar dapibus leo.
                </p>
              </div>
              <div class="consult-title mt-3 d-flex justify-content-start">
                <img src="{{ asset('dsimt-assets/images/') }}team/user-2.jpg" alt="" />
                <div class="ps-name">
                  <h5 class="mb-0">Amanda Lee</h5>
                  <span class="cl-orange">CEO & Founder Crix</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Testimonial ends -->

    <!--  Blog to action start -->
    <section class="home-3 blog-article bg-white">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline wow fadeInLeft">
          <div class="title-top">
            <div class="title-quote">
              <span class="bg-white">Our Blogs</span>
            </div>
            <h2>LATEST <span class="cl-blue">BLOG</span> & <span class="cl-blue">EVENTS</span></h2>
          </div>
        </div>
        <div class="blog-wrap">
          <div class="row">
            <div class="col-lg-4 col-md-6 wow fadeInRight">
              <div class="article-list">
                <div class="at-thumbnail">
                  <a href="blog-detail.html">
                    <img src="{{ asset('dsimt-assets/images/') }}blog/blog-1.jpg" alt="" />
                  </a>
                  <span class="blog-tag"> Education </span>
                </div>
                <div class="article-content">
                  <img src="{{ asset('dsimt-assets/images/') }}team/user-4.jpg" alt="" class="article-avatar" />
                  <div class="artl-detail">
                    <a href="blog-detail.html"><h4>NEW CHICAGO SCHOOL BUDGET RELIES ON PENSION</h4></a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
                    <a href="blog-detail.html" class="bl-link">Read More <i class="fas fa-angle-double-right"></i></a>
                  </div>
                  <div class="artl-bottom">
                    <ul class="d-flex justify-content-start">
                      <li>June 12, 2021</li>
                      <li><a href="#">2 Comments</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInRight">
              <div class="article-list">
                <div class="at-thumbnail">
                  <a href="blog-detail.html">
                    <img src="{{ asset('dsimt-assets/images/') }}blog/blog-2.jpg" alt="" />
                  </a>
                  <span class="blog-tag"> Education </span>
                </div>
                <div class="article-content">
                  <img src="{{ asset('dsimt-assets/images/') }}team/user-5.jpg" alt="" class="article-avatar" />
                  <div class="artl-detail">
                    <a href="blog-detail.html"><h4>NEW CHICAGO SCHOOL BUDGET RELIES ON PENSION</h4></a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
                    <a href="blog-detail.html" class="bl-link">Read More <i class="fas fa-angle-double-right"></i></a>
                  </div>
                  <div class="artl-bottom">
                    <ul class="d-flex justify-content-start">
                      <li>June 12, 2021</li>
                      <li><a href="#">2 Comments</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInRight">
              <div class="article-list">
                <div class="at-thumbnail">
                  <a href="blog-detail.html">
                    <img src="{{ asset('dsimt-assets/images/') }}blog/blog-3.jpg" alt="" />
                  </a>
                  <span class="blog-tag"> Education </span>
                </div>
                <div class="article-content">
                  <img src="{{ asset('dsimt-assets/images/') }}team/user-6.jpg" alt="" class="article-avatar" />
                  <div class="artl-detail">
                    <a href="blog-detail.html"><h4>NEW CHICAGO SCHOOL BUDGET RELIES ON PENSION</h4></a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
                    <a href="blog-detail.html" class="bl-link">Read More <i class="fas fa-angle-double-right"></i></a>
                  </div>
                  <div class="artl-bottom">
                    <ul class="d-flex justify-content-start">
                      <li>June 12, 2021</li>
                      <li><a href="#">2 Comments</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--  Blog to action end -->

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
