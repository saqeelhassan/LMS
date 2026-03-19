@extends('DSIMT-Webiste.layout')

@section('content')


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Contact Us</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Contact start -->
    <section class="contact-main pb-0">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="contact-info text-center">
              <i class="far fa-clock"></i>
              <h3>Our Hours</h3>
              <div class="ct__atdetail">
                <p>10:00 AM – 22.00 PM</p>
                <p>Monday – Sunday</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="contact-info text-center">
              <i class="far fa-map"></i>
              <h3>LOCATION</h3>
              <div class="ct__atdetail">
                <p>709 Honey Creek Dr.</p>
                <p>New York, NY 10028</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 text-center">
            <div class="contact-info">
              <i class="fas fa-phone-alt"></i>
              <h3>CONTACT US</h3>
              <div class="ct__atdetail">
                <p>Phone: 1 800 755 60 20</p>
                <p>Email: contact@company.com</p>
              </div>
            </div>
          </div>
        </div>
        <div class="contact-map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13805.978352059443!2d-118.1754712025183!3d34.06537185992424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c59d1d496b05%3A0xf8fb33950a3f77c!2sMonterey%20Park%20Golf%20Club!5e0!3m2!1sen!2snp!4v1633520157498!5m2!1sen!2snp"
            width="900"
            height="450"
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
          ></iframe>
        </div>
        <div class="contact-form">
          @if(session('success'))
            <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger text-center mb-4">
              <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
          @endif
          <form method="post" action="{{ route('dsimt.contact.store') }}" class="m-auto text-center">
            @csrf
            <div class="row mb-4">
              <div class="col">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}" required maxlength="255" />
                @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="form-outline mb-4">
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required maxlength="255" />
              @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="form-outline mb-4">
              <input type="text" name="phone" class="form-control" placeholder="Phone No." value="{{ old('phone') }}" maxlength="50" />
            </div>
            <div class="form-outline mb-4">
              <textarea name="message" class="form-control @error('message') is-invalid @enderror" placeholder="Message" rows="4" required maxlength="5000">{{ old('message') }}</textarea>
              @error('message')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn">Send Message</button>
          </form>
        </div>
      </div>
    </section>
    <!-- Contact end -->

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
