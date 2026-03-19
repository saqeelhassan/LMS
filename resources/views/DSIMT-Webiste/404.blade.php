@extends('DSIMT-Webiste.layout')

@section('content')


    <!-- Faq start -->
    <section class="error-page">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="d-flex">
              <img src="{{ asset('dsimt-assets/images/') }}shape/404-Error-02.png" alt="" />
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="service-inner d-flex flex-column justify-content-center h-100 text-center">
              <h2 class="mb-3">OOPS! THAT PAGE CAN'T BE FOUND</h2>
              <p>It looks like nothing was found at this location. Maybe try one of the links below or a search?</p>
              <div class="sidebar-search">
                <div class="input-group">
                  <div class="form-outline">
                    <input type="search" id="form1" class="form-control" placeholder="Search..." />
                  </div>
                  <button type="button" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--  Faq end -->

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
