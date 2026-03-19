@extends('DSIMT-Webiste.layout')

@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Govt Funded</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>

    <section class="about-company pb-0 inner-about">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="about-us-wrap">
              <div class="about-title">
                <h4 class="top-title mb-3">GOVERNMENT FUNDED PROGRAMS</h4>
                <h3 class="mb-3 pb-3">{{ $current['title'] }}</h3>
              </div>
              <div class="about-content">
                <p>
                  Digital Sindh IMT offers government-funded skill development programs in partnership with {{ $current['name'] }}.
                  These programs are designed to provide quality training and certification to eligible candidates.
                </p>
                <p class="mb-4">
                  For more information about eligibility, courses, and how to apply for the {{ $current['name'] }} program,
                  please contact us or visit our campus.
                </p>
                <a href="{{ route('dsimt.contact') }}" class="btn">Contact Us</a>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4 pt-4 border-top">
          <div class="col-12">
            <h5 class="mb-3">Other government-funded programs</h5>
            <ul class="list-unstyled d-flex flex-wrap gap-2">
              @foreach($programs as $slug => $info)
                @if($slug !== $program)
                  <li><a href="{{ route('dsimt.govt-funded.show', $slug) }}" class="btn btn-outline-primary btn-sm">{{ $info['name'] }}</a></li>
                @endif
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </section>
@endsection
