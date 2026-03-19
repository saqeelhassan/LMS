@extends('DSIMT-Webiste.layout')

@section('content')


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Event Detail</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <section class="event-detail-cn">
      <div class="container">
        <div class="ev-detail-info d-flex flex-column justify-content-center align-items-center text-center h-100">
          <h3>TED TALKS AT UCF COLLEGE OF EDUCATION</h3>
          <div class="customize-bottom">
            <ul class="d-flex justify-content-start">
              <li class="mr-3"><i class="far fa-user"></i> Elon Gated</li>
              <li><i class="far fa-calendar-alt"></i> 06 June, 2021</li>
            </ul>
          </div>
          <div class="ev-image">
            <img src="{{ asset('dsimt-assets/images/') }}inner/education-8345AGC.jpg" alt="" />
          </div>
        </div>
        <div class="ev-detail-content">
          <div class="evt__section">
            <h3>Description</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, consectetur? Cupiditate quas placeat cumque ad exercitationem dolore, autem
              tenetur eligendi earum culpa molestiae recusandae commodi molestias libero harum dolorem mollitia! Lorem ipsum dolor sit amet consectetur
              adipisicing elit. Nemo hic at cum autem quos molestias doloremque animi debitis voluptas natus ratione odit voluptates quibusdam placeat, in ipsam
              corrupti perspiciatis assumenda beatae!
            </p>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe nesciunt, quo asperiores molestiae quibusdam vitae officia eius dignissimos ab
              dolores optio voluptates dolor cupiditate autem placeat nam quas ut voluptate accusamus cum repellat harum incidunt unde ex. Aut ratione, odit
              nulla voluptatem vitae placeat mollitia asperiores, illo quia eum impedit commodi sapiente unde reiciendis ex totam tempore necessitatibus
              blanditiis hic molestias doloremque in error vero dicta.
            </p>
          </div>
          <div class="evt__section">
            <h3>THIS EVENTS WILL ALLOW PARTICIPANTS TO:</h3>
            <ul class="d-flex flex-column">
              <li><i class="fas fa-check"></i> Business's managers, leaders</li>
              <li><i class="fas fa-check"></i> Downloadable lectures, code and design assets for all projects</li>
              <li><i class="fas fa-check"></i> Anyone who is finding a chance to get the promotion</li>
            </ul>
          </div>
          <div class="evt__section row mt-3 pb-0">
            <div class="col-lg-6">
              <div class="event-logo">
                <img src="{{ asset('dsimt-assets/images/') }}cropped-epathsala_favicon-300x300.png" alt="" />
              </div>
            </div>
            <div class="col-lg-6">
              <div class="event-form">
                <span class="cl-blue">Feel free to register your name</span>
                <h3>Join Now</h3>
                <form>
                  <!-- 2 column grid layout with text inputs for the first and last names -->
                  <div class="row mb-3">
                    <div class="col">
                      <div class="form-outline">
                        <input type="text" id="form6Example1" class="form-control" placeholder="Name" />
                      </div>
                    </div>
                  </div>

                  <!-- Email input -->
                  <div class="form-outline mb-3">
                    <input type="email" id="form6Example5" class="form-control" placeholder="Email" />
                  </div>

                  <!-- Number input -->
                  <div class="form-outline mb-3">
                    <input type="number" id="form6Example6" class="form-control" placeholder="Phone No." />
                  </div>

                  <!-- Message input -->
                  <div class="form-outline mb-3">
                    <textarea class="form-control" id="form6Example7" placeholder="Message" rows="4"></textarea>
                  </div>

                  <!-- Submit button -->
                  <button type="submit" class="btn mb-4">Submit Now</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- News/Events news start -->
    <section class="courses news-events p-0">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline">
          <div class="title-top">
            <div class="title-quote">
              <span>Related Events</span>
            </div>
            <h2>BROWSE ONLINE RELATED <span class="cl-blue">EVENTS</span></h2>
          </div>
        </div>
        <div class="wrap-customize">
          <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 customize-wrap wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-1.jpg" alt="" />
                </div>
                <div class="customize-ct">
                  <h4>
                    <a href="#">TED TALKS AT UCF COLLEGE OF EDUCATION</a>
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
                    <a href="#">IMPORTANCES OF RESEARCH SEMINAR 2021</a>
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
                    <a href="#">NEWLY SUMMER COURSE STARTS FROM JUNE</a>
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
                    <a href="#">TED TALKS AT UCF COLLEGE OF EDUCATION</a>
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
                    <a href="#">IMPORTANCES OF RESEARCH SEMINAR 2021</a>
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
                    <a href="#">NEWLY SUMMER COURSE STARTS FROM JUNE</a>
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
