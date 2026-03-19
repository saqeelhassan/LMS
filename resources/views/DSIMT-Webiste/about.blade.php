@extends('DSIMT-Webiste.layout')

@section('content')


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>About Us</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- About start -->
    <section class="about-company pb-0 inner-about">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-12 wow fadeInLeftBig">
            <div class="about-wrap-img">
              <img src="{{ asset('dsimt-assets/images/') }}inner/abt-1.jpg" alt="" />
            </div>
          </div>
          <div class="col-lg-7 col-md-12 wow fadeInRightBig">
            <div class="about-us-wrap">
              <div class="about-title">
                <h4 class="top-title mb-3">ABOUT DSIMT</h4>
                <h3 class="mb-3 pb-3">LEARN SOMETHING NEW, AND GROW YOUR <span class="cl-blue">SKILL</span></h3>
              </div>
              <div class="about-content">
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum dignissimos, deleniti adipisci ut inventore commodi iure explicabo excepturi
                  cumque laudantium quis praesentium id nesciunt! Soluta sunt obcaecati aspernatur nostrum ab.
                </p>
                <p class="mb-4">
                  Using our single innovative platform you can remove all your communication dependencies and the messy rat’s nest of email, calls, texts,
                  wikis, and apps you currently have.
                </p>
                <a href="course-1.html" class="btn">View Course</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- About end -->

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
                      <h4 class="top-title mb-3">Fall 2021 applications are now open</h4>
                      <h2 class="mb-3 pb-3 cl-white">APPLY FOR ADMISSION</h2>
                    </div>
                    <div class="serv-content">
                      <p class="cl-white">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                        minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
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
                    <i class="far fa-user"></i>
                    <div class="serv-list text-left">
                      <h4 class="cl-white mb-0">UNIVERSITY LIFE</h4>
                      <span>Overall in here</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 p-0">
                  <div class="service-ct-list bg-scgreen">
                    <i class="fas fa-book-open"></i>
                    <div class="serv-list text-left">
                      <h4 class="cl-white mb-0">GRADUATION</h4>
                      <span>Getting Diploma</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 p-0">
                  <div class="service-ct-list bg-sc-lblue">
                    <i class="fas fa-globe-americas"></i>
                    <div class="serv-list text-left">
                      <h4 class="cl-white mb-0">BEST INSTRUCTORS</h4>
                      <span>Certified Teachers</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 pl-0">
                  <div class="service-ct-list bg-sc-dblue">
                    <i class="fas fa-book"></i>
                    <div class="serv-list text-left">
                      <h4 class="cl-white mb-0">GLOBAL HUBS</h4>
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

    <!-- Counter main -->
    <section class="counter">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline">
          <div class="title-top">
            <div class="title-quote">
              <span>Our Achievements</span>
            </div>
            <h2>WE ARE <span class="cl-blue">PROUD</span></h2>
          </div>
        </div>
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
        <div class="course-bse">
          <div class="d-flex align-items-center justify-content-center">
            <div class="course-b-list">
              <h4 class="cl-blue">UNDERGRADUATE</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            </div>
            <div class="course-b-list bg-darkblue">
              <h4 class="cl-blue">GRADUATED & PROFESSIONAL</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            </div>
            <div class="course-b-list">
              <h4 class="cl-blue">SCHOLARSHIP AID</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Counter main -->

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
        <div class="row instruct-main wow fadeInLeft">
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
              <div class="consult-content mb-4">
                <p class="mb-0">
                  I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec
                  ullamcorper mattis, pulvinar dapibus leo.
                </p>
              </div>
              <div class="consult-title d-flex justify-content-start">
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
              <div class="consult-content mb-4">
                <p class="mb-0">
                  I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec
                  ullamcorper mattis, pulvinar dapibus leo.
                </p>
              </div>
              <div class="consult-title d-flex justify-content-start">
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
