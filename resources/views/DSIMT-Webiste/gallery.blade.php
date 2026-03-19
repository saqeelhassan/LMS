@extends('DSIMT-Webiste.layout')

@section('content')


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Our Gallery</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Gallery start -->
    <div class="gallery">
      <div class="container">
        <div id="macy-container">
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}inner/modern-education-business-startup-friendship-an-2021-07-27-05-12-15-utc-1.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}inner/modern-education-business-startup-friendship-an-2021-07-27-05-12-15-utc-1.jpg" alt="" class="demo-image wow fadeInUp" />
            </a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}lightbox/education-students-people-knowledge-concept-2021-04-02-19-49-59-utc.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}lightbox/education-students-people-knowledge-concept-2021-04-02-19-49-59-utc.jpg" alt="" class="demo-image wow fadeInUp" />
            </a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}lightbox/education-students-people-knowledge-concept-PGGPVWJ.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}lightbox/education-students-people-knowledge-concept-PGGPVWJ.jpg" alt="" class="demo-image wow fadeInUp" />
            </a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}lightbox/group-of-people-attending-education-class-in-commu-2021-05-28-22-34-30-utc.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}lightbox/group-of-people-attending-education-class-in-commu-2021-05-28-22-34-30-utc.jpg" alt="" class="demo-image wow fadeInUp"
            /></a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}inner/cloister-of-the-university-of-milan-N8MH3V3.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}inner/cloister-of-the-university-of-milan-N8MH3V3.jpg" alt="" class="demo-image wow fadeInUp"
            /></a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}inner/education-2021-04-09-20-17-44-utc.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}inner/education-2021-04-09-20-17-44-utc.jpg" alt="" class="demo-image wow fadeInUp"
            /></a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}inner/education-8345AGC.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}inner/education-8345AGC.jpg" alt="" class="demo-image wow fadeInUp"
            /></a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}inner/education-C6PKGFN.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}inner/education-C6PKGFN.jpg" alt="" class="demo-image wow fadeInUp"
            /></a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}inner/education-F32W3ZT.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}inner/education-F32W3ZT.jpg" alt="" class="demo-image wow fadeInUp"
            /></a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}inner/education-students-people-knowledge-concept-2021-04-02-19-49-59-utc.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}inner/education-students-people-knowledge-concept-2021-04-02-19-49-59-utc.jpg" alt="" class="demo-image wow fadeInUp" />
            </a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}inner/friends-studying-in-the-park-2021-04-02-20-21-17-utc.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}inner/friends-studying-in-the-park-2021-04-02-20-21-17-utc.jpg" alt="" class="demo-image wow fadeInUp"
            /></a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}banner/education-PHW33SU.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}banner/education-PHW33SU.jpg" alt="" class="demo-image wow fadeInUp" />
            </a>
          </div>
          <div class="demo">
            <a href="{{ asset('dsimt-assets/images/') }}banner/education-2021-04-04-14-25-07-utc.jpg" data-lightbox="gallery">
              <img src="{{ asset('dsimt-assets/images/') }}banner/education-2021-04-04-14-25-07-utc.jpg" alt="" class="demo-image wow fadeInUp" />
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Gallery end -->

    <!--  Newsletter start -->
    <section class="newsletter pt-0">
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
