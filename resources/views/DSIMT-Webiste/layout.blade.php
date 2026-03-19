<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">
  <head>
    @include('DSIMT-Webiste.partials.head-assets')
  </head>
  <body class="">
    <!-- Preloader -->
    <div id="preloader">
      <div id="status"></div>
    </div>
    <!-- Preloader Ends -->

    @include('DSIMT-Webiste.Header & Footer.header')

    @yield('content')

    @include('DSIMT-Webiste.Header & Footer.footer')

    <!-- Search form popup -->
    <form action="#" class="ct-searchForm">
      <div class="inner">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-sm-8">
              <div class="form-group">
                <input id="cf-search-form" type="text" placeholder="Search ..." required class="form-control" />
                <button type="submit" class="ct-search-btn"><i class="fa fa-search"></i></button>
              </div>
              <div class="form-group">
                <a href="#" class="ct-searchForm-close">
                  <i class="fas fa-times"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- Search form popup end -->

    <!-- Back to top start -->
    <div id="back-to-top">
      <a href="#"></a>
    </div>
    <!-- Back to top ends -->

    @include('DSIMT-Webiste.partials.scripts')
  </body>
</html>
