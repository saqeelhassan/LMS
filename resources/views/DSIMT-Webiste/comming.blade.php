<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>DSIMT - Online Education Template</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dsimt-assets/images/') }}cropped-epathsala_favicon-192x192.png" />
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('dsimt-assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!--Custom CSS-->
    <link href="{{ asset('dsimt-assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <!--Plugin CSS-->
    <link href="{{ asset('dsimt-assets/css/plugin.css') }}" rel="stylesheet" type="text/css" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader">
      <div id="status"></div>
    </div>
    <!-- Preloader Ends -->

    <!-- Faq start -->
    <section class="comming-soon">
      <div class="container">
        <div class="comming__soon_text">
          <i class="fas fa-archway"></i>
          <h1 class="cl-white">Under Construction</h1>
          <p class="cl-orange">Our website is under construction. We will be here soon with our awesome new site, subscribe to be notified.</p>
          <div id="countdown"></div>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!--  Faq end -->

    <!-- *Scripts* -->
    <script src="{{ asset('dsimt-assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('dsimt-assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dsimt-assets/js/plugin.js') }}"></script>
    <script src="{{ asset('dsimt-assets/js/main.js') }}"></script>
    <script src="{{ asset('dsimt-assets/js/custom-swiper.js') }}"></script>
    <script src="{{ asset('dsimt-assets/js/custom-nav.js') }}"></script>
    <script>
      //Countdown
      // Set the date we're counting down to
      var countDownDate = new Date("Jan 5, 2022 15:37:25").getTime();

      // Update the count down every 1 second
      var x = setInterval(function () {
        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="countdown"
        document.getElementById("countdown").innerHTML =
          days + "<span>Days </span>" + hours + "<span>Hours </span>" + minutes + "<span>Minutes </span>" + seconds + "<span>Seconds </span>";

        // If the count down is over, write some text
        if (distance < 0) {
          clearInterval(x);
          document.getElementById("countdown").innerHTML = "EXPIRED";
        }
      }, 1000);
    </script>
  </body>
</html>
