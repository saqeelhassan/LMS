@extends('DSIMT-Webiste.layout')

@section('content')


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Our Team</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Our Team start (Instructors & Admins from LMS) -->
    <section class="instructors pb-0">
      <div class="container">
        <div class="row instruct-main wow fadeInLeft">
          @forelse($team as $index => $member)
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="ins-main-list {{ $index >= 4 ? 'mt-5' : '' }}">
              @if($member->avatar_url)
                <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" />
              @else
                <img src="{{ asset('dsimt-assets/images/team/team-' . (($index % 4) + 1) . '.jpg') }}" alt="{{ $member->name }}" />
              @endif
              <div class="ins-names">
                <h4>{{ $member->name }}</h4>
                <span class="cl-orange">{{ $member->role?->name ?? 'Team' }}</span>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12 text-center py-5">
            <p class="text-body-secondary mb-0">No team members to display yet. Instructors and Admins added in the LMS will appear here.</p>
          </div>
          @endforelse
        </div>
      </div>
    </section>
    <!-- Our Team ends -->

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
