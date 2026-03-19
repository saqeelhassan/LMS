@extends('DSIMT-Webiste.layout')

@section('content')


    <!-- Blog title starts -->
    <section class="blog-top-title">
      <div class="bg_bar_title">
        <h1 class="cl-white">FITTECH & KEY INVESTMENT CONFERENCE</h1>
        <p class="cl-white">September 21</p>
      </div>
      <div class="bg__bar_image">
        <img src="{{ asset('dsimt-assets/images/') }}inner/education-F32W3ZT.jpg" alt="" />
      </div>
    </section>
    <!-- Blog title end -->

    <!--  Blog to action start -->
    <section class="blog__details p-0">
      <div class="container">
        <div class="bg__author d-flex align-items-center">
          <img src="{{ asset('dsimt-assets/images/') }}team/user-2.jpg" alt="" />
          <div class="bg__author_name">
            <h4>Marta Fleming</h4>
            <span>Founder and Co-owner</span>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="bg__contents">
              <div class="author__datetime">
                <ul>
                  <li>
                    <a href="#"><i class="far fa-user-circle"></i> html_design</a>
                  </li>
                  <li><i class="far fa-calendar"></i> August 11, 2021</li>
                  <li><i class="far fa-clock"></i> 6:47 am</li>
                  <li>
                    <a href="#"><i class="fas fa-comment-dots"></i> No Comments</a>
                  </li>
                </ul>
              </div>
              <div class="bg__only_detail">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                  veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
                  anim id est laborum.
                </p>
                <ul class="">
                  <li>Purus sequi accusamus? Nibh aut perspiciatis, lorem lorem perspiciatis.</li>
                  <li>Dictum? Posuere cumque sed illum facilisis leo illum facilisis.</li>
                  <li>Neque officiis feugiat praesentium qui, aliqua hic commodo praesentium.</li>
                  <li>Asperiores irure class lobortis veritatis, alias sem lobortis veritatis.</li>
                  <li>Ipsum eros quaerat deserunt proin porttitor, fugit ultrices.</li>
                  <li>Volutpat, justo mollit ullamco sagittis duis enim labore, ullamcorper dicta.</li>
                </ul>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                  veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
                  anim id est laborum.
                </p>

                <!--Accordion wrapper-->
                <div class="accordion md-accordion mt-3" id="accordionEx1" role="tablist" aria-multiselectable="true">
                  <!-- Accordion card -->
                  <div class="card">
                    <!-- Card header -->
                    <div class="card-header" role="tab" id="headingTwo1">
                      <a
                        class="collapsed"
                        data-toggle="collapse"
                        data-parent="#accordionEx1"
                        href="#collapseTwo1"
                        aria-expanded="false"
                        aria-controls="collapseTwo1"
                      >
                        <h5 class="mb-0">TABLE OF CONTENTS <i class="fas fa-plus"></i></h5>
                      </a>
                    </div>

                    <!-- Card body -->
                    <div id="collapseTwo1" class="collapse show" role="tabpanel" aria-labelledby="headingTwo1" data-parent="#accordionEx1">
                      <div class="card-body">
                        <ol>
                          <li><a href="#">JACK GRANT</a></li>
                          <li>
                            <a href="#">Leave a Reply Cancel reply</a>
                            <ol>
                              <li><a href="#">YOU MIGHT ALSO ENJOY</a></li>
                              <li><a href="#">NEW CHICAGO SCHOOL BUDGET RELIES ON PENSION</a></li>
                              <li><a href="#">THE CHALLENGE OF LEARNING IN PUBLIC EDUCATION</a></li>
                              <li><a href="#">EXACTLY HOW TECHNOLOGY CAN MAKE READING BETTER</a></li>
                              <li><a href="#">GROW YOUR BUSINESS BY MASTERED TECHNIQUE</a></li>
                              <li><a href="#">LEADERSHIP: STRATEGIES FOR A SUCCESSFUL BUSINESS</a></li>
                              <li><a href="#">FOLLOW US</a></li>
                            </ol>
                          </li>
                        </ol>
                      </div>
                    </div>
                  </div>
                  <!-- Accordion card -->
                </div>
                <!-- Accordion wrapper -->

                <blockquote>
                  <span>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.Lorem ipsum
                    dolor sit amet consectetur adipiscing elit dolor</span
                  >
                  <p>John Doe</p>
                  <button class="btn btn-curve"><i class="fab fa-twitter"></i> Tweet</button>
                </blockquote>
              </div>
              <div class="blg__ct_form">
                <h3>Leave a Reply</h3>
                <p>Your email address will not be published. Required fields are marked *</p>
                <form class="mt-4">
                  <!-- Message input -->
                  <div class="form-outline mb-4">
                    <label for="">Comment</label>
                    <textarea class="form-control" id="form6Example7" rows="4"></textarea>
                  </div>

                  <!-- 2 column grid layout with text inputs for the first and last names -->
                  <div class="row mb-3">
                    <div class="col">
                      <div class="form-outline">
                        <label for="">Name *</label>
                        <input type="text" id="form6Example1" class="form-control" />
                      </div>
                    </div>
                  </div>
                  <!-- Email input -->
                  <div class="form-outline mb-3">
                    <label for="">Email *</label>
                    <input type="email" id="form6Example5" class="form-control" />
                  </div>

                  <!-- Number input -->
                  <div class="form-outline mb-3">
                    <label for="">Website</label>
                    <input type="text" id="form6Example6" class="form-control" />
                  </div>
                  <!-- Checkbox -->
                  <div class="form-check d-flex justify-content-start mb-4">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form6Example8" checked />
                    <label class="form-check-label" for="form6Example8"> Save my name, email, and website in this browser for the next time I comment. </label>
                  </div>
                  <!-- Submit button -->
                  <button type="submit" class="btn">Post Comment</button>
                </form>
              </div>
              <div class="prev-next-page d-flex justify-content-between align-items-center mt-4">
                <div class="prev-navlink-page">
                  <a href="#">
                    <i class="fas fa-angle-double-left"></i>
                    <div class="prevnext__nav">
                      <p>Previous</p>
                      <h5>FITTECH & KEY INVESTMENT CONFERENCE</h5>
                    </div>
                  </a>
                </div>
                <div class="next-navlink-page">
                  <a href="#">
                    <i class="fas fa-angle-double-right"></i>
                    <div class="prevnext__nav">
                      <p>Next</p>
                      <h5>THE NEXT GENERATION OF BUSINESS LEADERS</h5>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-12 aside-sidebar customize-wrap wow fadeInUp">
            <div class="sidebar-profile mb-4">
              <div class="sidebar-title">
                <h4>RECENT POSTS</h4>
              </div>
              <div class="ss__myprofile">
                <img src="{{ asset('dsimt-assets/images/') }}team/user-1.jpg" alt="" />
                <h4>Keyan Spears</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit dolor</p>
              </div>
            </div>

            <div class="sidebar-course mb-4">
              <div class="sidebar-title">
                <h4>RECENT POSTS</h4>
              </div>
              <div class="customize-item d-flex mb-3">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/course-2.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">EPATHSHALA’S ALUMNI HOT AIR BALLON TRIP IN TURKEY</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
              <div class="customize-item d-flex mb-3">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/event-1.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">THE NEXT GENERATION OF BUSINESS LEADERS</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
              <div class="customize-item d-flex mb-3">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/course-4.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">REUNION EVENT: EPATHSHALA’S ALUMNI GOLF TOUR</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
              <div class="customize-item d-flex">
                <div class="sv-image pr-3">
                  <img src="{{ asset('dsimt-assets/images/') }}courses/course-3.jpg" alt="" />
                </div>
                <div class="customize-ct m-0">
                  <h6 class="mb-0">
                    <a href="#">EPATHSHALA’S ALUMNI HOT AIR BALLON TRIP IN TURKEY</a>
                  </h6>
                  <span class="cust-meta"> August 20, 2021</span>
                </div>
              </div>
            </div>

            <div class="sidebar-links">
              <div class="sidebar-title">
                <h4>follow us</h4>
              </div>
              <div class="side-contact-wp text-center mb-4">
                <ul class="sidebar-social mb-3">
                  <li>
                    <a href="#" class="bg-fb"><i class="fab fa-facebook-f"></i> Facebook</a>
                  </li>
                  <li>
                    <a href="#" class="bg-twitter"><i class="fab fa-twitter"></i> Twitter</a>
                  </li>
                  <li>
                    <a href="#" class="bg-pin"><i class="fab fa-pinterest-p"></i> Pinterest</a>
                  </li>
                  <li>
                    <a href="#" class="bg-linkedin"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                  </li>
                  <li>
                    <a href="#" class="bg-dribble"><i class="fab fa-dribbble"></i> Dribble</a>
                  </li>
                  <li>
                    <a href="#" class="bg-youtube"><i class="fab fa-youtube"></i> YouTube</a>
                  </li>
                </ul>
                <button class="btn">Student Resourses</button>
              </div>
              <img src="{{ asset('dsimt-assets/images/') }}inner/education-2021-04-09-20-17-44-utc.jpg" alt="" />
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--  Blog to action end -->

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
