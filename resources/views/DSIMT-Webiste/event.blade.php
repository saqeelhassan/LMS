@extends('DSIMT-Webiste.layout')

@section('content')


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Event List</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Event tabs start -->
    <section class="schedule-tabs">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline">
          <div class="title-top">
            <div class="title-quote">
              <span>Browse Events</span>
            </div>
            <h2>Pre Events <span class="cl-blue">Schedules</span></h2>
          </div>
        </div>
        <div class="sche_tab_list">
          <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="pills-1-tab" data-toggle="pill" href="#pills-1" role="tab" aria-controls="pills-1" aria-selected="true">Day 1</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="pills-2-tab" data-toggle="pill" href="#pills-2" role="tab" aria-controls="pills-2" aria-selected="false">Day 2</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="pills-3-tab" data-toggle="pill" href="#pills-3" role="tab" aria-controls="pills-3" aria-selected="false">Day 3</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="pills-4-tab" data-toggle="pill" href="#pills-4" role="tab" aria-controls="pills-4" aria-selected="false">Day 4</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="pills-5-tab" data-toggle="pill" href="#pills-5" role="tab" aria-controls="pills-5" aria-selected="false">Day 5</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
              <span>May-15-2021 9.00 AM-11.45PM</span>
              <h4>INTRODUCTION OF CREATIVE DESIGN</h4>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum
                suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing
                elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                accumsan lacus vel facilisis.
              </p>
            </div>
            <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
              <span>May-15-2021 9.00 AM-11.45PM</span>
              <h4>GETTING STARTED WITH CREATIVE DESIGN</h4>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum
                suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing
                elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                accumsan lacus vel facilisis.
              </p>
            </div>
            <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
              <span>May-15-2021 9.00 AM-11.45PM</span>
              <h4>INTRODUCTION OF CREATIVE DESIGN</h4>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum
                suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing
                elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                accumsan lacus vel facilisis.
              </p>
            </div>
            <div class="tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab">
              <span>May-15-2021 9.00 AM-11.45PM</span>
              <h4>GETTING STARTED WITH CREATIVE DESIGN</h4>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum
                suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing
                elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                accumsan lacus vel facilisis.
              </p>
            </div>
            <div class="tab-pane fade" id="pills-5" role="tabpanel" aria-labelledby="pills-5-tab">
              <span>May-15-2021 9.00 AM-11.45PM</span>
              <h4>INTRODUCTION OF CREATIVE DESIGN</h4>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum
                suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing
                elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                accumsan lacus vel facilisis.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Event tabs end -->

    <!-- News/Events news start -->
    <section class="courses news-events pt-0">
      <div class="container">
        <div class="wrap-customize">
          <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 customize-wrap wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-1.jpg" alt="" />
                </div>
                <div class="customize-ct">
                  <h4>
                    <a href="event-detail.html">TED TALKS AT UCF COLLEGE OF EDUCATION</a>
                  </h4>
                </div>
                <div class="customize-bottom">
                  <ul class="d-flex justify-content-start">
                    <li class="mr-3"><i class="far fa-calendar-alt"></i> 30 July</li>
                    <li class="mr-3"><i class="far fa-clock"></i> 9AM</li>
                    <li><i class="fas fa-map-marker-alt"></i> Melbourne</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 customize-wrap wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-2.jpg" alt="" />
                </div>
                <div class="customize-ct">
                  <h4>
                    <a href="event-detail.html">IMPORTANCES OF RESEARCH SEMINAR 2021</a>
                  </h4>
                </div>
                <div class="customize-bottom">
                  <ul class="d-flex justify-content-start">
                    <li class="mr-3"><i class="far fa-calendar-alt"></i> 30 July</li>
                    <li class="mr-3"><i class="far fa-clock"></i> 9AM</li>
                    <li><i class="fas fa-map-marker-alt"></i> Melbourne</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 customize-wrap wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-3.jpg" alt="" />
                </div>
                <div class="customize-ct">
                  <h4>
                    <a href="event-detail.html">NEWLY SUMMER COURSE STARTS FROM JUNE</a>
                  </h4>
                </div>
                <div class="customize-bottom">
                  <ul class="d-flex justify-content-start">
                    <li class="mr-3"><i class="far fa-calendar-alt"></i> 30 July</li>
                    <li class="mr-3"><i class="far fa-clock"></i> 9AM</li>
                    <li><i class="fas fa-map-marker-alt"></i> Melbourne</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 customize-wrap wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-1.jpg" alt="" />
                </div>
                <div class="customize-ct">
                  <h4>
                    <a href="event-detail.html">TED TALKS AT UCF COLLEGE OF EDUCATION</a>
                  </h4>
                </div>
                <div class="customize-bottom">
                  <ul class="d-flex justify-content-start">
                    <li class="mr-3"><i class="far fa-calendar-alt"></i> 30 July</li>
                    <li class="mr-3"><i class="far fa-clock"></i> 9AM</li>
                    <li><i class="fas fa-map-marker-alt"></i> Melbourne</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 customize-wrap wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-2.jpg" alt="" />
                </div>
                <div class="customize-ct">
                  <h4>
                    <a href="event-detail.html">IMPORTANCES OF RESEARCH SEMINAR 2021</a>
                  </h4>
                </div>
                <div class="customize-bottom">
                  <ul class="d-flex justify-content-start">
                    <li class="mr-3"><i class="far fa-calendar-alt"></i> 30 July</li>
                    <li class="mr-3"><i class="far fa-clock"></i> 9AM</li>
                    <li><i class="fas fa-map-marker-alt"></i> Melbourne</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 customize-wrap wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-3.jpg" alt="" />
                </div>
                <div class="customize-ct">
                  <h4>
                    <a href="event-detail.html">NEWLY SUMMER COURSE STARTS FROM JUNE</a>
                  </h4>
                </div>
                <div class="customize-bottom">
                  <ul class="d-flex justify-content-start">
                    <li class="mr-3"><i class="far fa-calendar-alt"></i> 30 July</li>
                    <li class="mr-3"><i class="far fa-clock"></i> 9AM</li>
                    <li><i class="fas fa-map-marker-alt"></i> Melbourne</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- News/Events news start -->

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
