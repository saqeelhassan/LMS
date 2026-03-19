@extends('DSIMT-Webiste.layout')

@section('content')
    <!-- Blog article header -->
    <section class="blog-top-title">
      <div class="bg_bar_title">
        <h1 class="cl-white">{{ $blog->title }}</h1>
        <p class="cl-white">{{ $blog->updated_at->format('F j, Y') }}</p>
      </div>
      <div class="bg__bar_image">
        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" />
      </div>
    </section>
    <!-- Blog title end -->

    <section class="blog__details p-0">
      <div class="container">
        <div class="bg__author d-flex align-items-center">
          @if($blog->author && $blog->author->avatar_url)
            <img src="{{ $blog->author->avatar_url }}" alt="{{ $blog->author->name }}" />
          @else
            <img src="{{ asset('dsimt-assets/images/team/user-2.jpg') }}" alt="" />
          @endif
          <div class="bg__author_name">
            <h4>{{ $blog->author->name ?? '—' }}</h4>
            <span>Author</span>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="bg__contents">
              <div class="author__datetime">
                <ul>
                  <li><i class="far fa-user-circle"></i> {{ $blog->author->name ?? '—' }}</li>
                  <li><i class="far fa-calendar"></i> {{ $blog->updated_at->format('F j, Y') }}</li>
                </ul>
              </div>
              <div class="bg__only_detail">
                {!! nl2br(e($blog->content)) !!}
              </div>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <a href="{{ route('dsimt.blog') }}" class="btn btn-outline-primary">Back to Blog</a>
        </div>
      </div>
    </section>
@endsection
