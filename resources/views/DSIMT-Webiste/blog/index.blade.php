@extends('DSIMT-Webiste.layout')

@section('content')
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Blog</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>

    <section class="home-2 blog-article blog-singlelist">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="blog-wrap">
              <div class="row">
                @forelse($blogs as $blog)
                <div class="col-lg-6 col-md-6 mb-4 wow fadeInRight">
                  <div class="article-list">
                    <div class="at-thumbnail">
                      <a href="{{ route('dsimt.blog.show', $blog) }}">
                        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" />
                      </a>
                      <span class="blog-tag">Blog</span>
                    </div>
                    <div class="article-content">
                      <img src="{{ $blog->author && $blog->author->avatar_url ? $blog->author->avatar_url : asset('dsimt-assets/images/team/user-4.jpg') }}" alt="" class="article-avatar" />
                      <div class="artl-detail">
                        <a href="{{ route('dsimt.blog.show', $blog) }}"><h4>{{ $blog->title }}</h4></a>
                        <p>{{ $blog->excerpt }}</p>
                        <a href="{{ route('dsimt.blog.show', $blog) }}" class="bl-link">Read More <i class="fas fa-angle-double-right"></i></a>
                      </div>
                      <div class="artl-bottom">
                        <ul class="d-flex justify-content-start">
                          <li>{{ $blog->updated_at->format('F j, Y') }}</li>
                          <li>{{ $blog->author->name ?? '—' }}</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                  <p class="text-body-secondary mb-0">No blog posts yet.</p>
                </div>
                @endforelse
              </div>
              @if($blogs->hasPages())
              <div class="d-flex justify-content-center mt-4">
                {{ $blogs->withQueryString()->links() }}
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
