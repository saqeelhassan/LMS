{{-- Start of DSIMT Header - Logo, nav, LMS link. Edit this file to change site navigation. --}}
<!-- header starts -->
<header class="main_header_area">
      <div class="topbar-wrap">
        <div class="container">
          <div class="top-info d-flex justify-content-between align-items-center">
            <ul class="t-address">
              <li><i class="fas fa-phone-alt"></i> (+92) 306 0934322 </li>
              <li><i class="far fa-envelope"></i> info@dsimt.edu.pk</li>
              <li><i class="fas fa-map-marker-alt"></i> House B-88, Phase 1, Qasimabad, Hyderabad.</li>
            </ul>
            <ul class="t-social d-flex align-items-center">
              <li>
                <a href="https://www.facebook.com/DSIMTHYD"><i class="fab fa-facebook-f"></i></a>
              </li>
              <li>
                <a href="https://www.instagram.com/digital_sindh_imt/"><i class="fab fa-instagram"></i></a>
              </li>
              <li>
                <a href="#"><i class="fab fa-twitter"></i></a>
              </li>
              <li>
                <span class="ct-search-link"
                  ><a href="{{ route('dsimt.search') }}"><i class="fa fa-search"></i></a
                ></span>
              </li>
              <li class="ms-2 ms-md-3">
                <a href="{{ route('login') }}" class="btn btn-sm btn-primary text-nowrap">LMS</a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Navigation Bar -->
      <div class="header_menu">
        <nav class="navbar navbar-default">
          <div class="container">
            <div class="navbar-flex d-flex align-items-center justify-content-between w-100">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand text-center" href="{{ route('dsimt.index') }}">
                  <img src="{{ asset('images/logo.png') }}" alt="DSIMT" />
                </a>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="navbar-collapse1 w-100" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" id="responsive-menu">
                  <li class="{{ request()->routeIs('dsimt.index') || request()->routeIs('index') ? 'active' : '' }}"><a href="{{ route('dsimt.index') }}">Home</a></li>
                  <li class="{{ request()->routeIs('dsimt.about') ? 'active' : '' }}"><a href="{{ route('dsimt.about') }}">About Us</a></li>
                  <li class="{{ request()->routeIs('dsimt.course*') ? 'active' : '' }}"><a href="{{ route('dsimt.course') }}">Courses</a></li>
                  <li class="{{ request()->routeIs('dsimt.event*') ? 'active' : '' }}"><a href="{{ route('dsimt.event') }}">Events</a></li>
                  <li class="dropdown submenu {{ request()->routeIs('dsimt.govt-funded.*') ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                      >Govt Funded <i class="fas fa-chevron-down"></i
                    ></a>
                    <ul class="dropdown-menu">
                      <li><a href="{{ route('dsimt.govt-funded.show', 'pitp') }}">PITP</a></li>
                      <li><a href="{{ route('dsimt.govt-funded.show', 'navttc') }}">NAVTTC</a></li>
                      <li><a href="{{ route('dsimt.govt-funded.show', 'bbshrrda') }}">BBSHRRDA</a></li>
                    </ul>
                  </li>
                  <li class="{{ request()->routeIs('dsimt.career*') ? 'active' : '' }}"><a href="{{ route('dsimt.career') }}">Career</a></li>
                  <li class="{{ request()->routeIs('dsimt.contact') ? 'active' : '' }}"><a href="{{ route('dsimt.contact') }}">Contact Us</a></li>
                </ul>
              </div>
              <!-- /.navbar-collapse -->
              <div id="slicknav-mobile"></div>
            </div>
          </div>
          <!-- /.container-fluid -->
        </nav>
      </div>
      <!-- Navigation Bar Ends -->
    </header>
    <!-- header ends -->