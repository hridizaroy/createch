<?php
  require 'db.php';
  session_start();

  //Checking if logged in and active
  if ( isset($_SESSION['logged_in']) ) {
    if($_SESSION['logged_in'] and $_SESSION['active'] and $_SESSION['police'] and $_SESSION['verified']){
        header("location: landing_page_pol.php");
    }
    else if ($_SESSION['logged_in'] and $_SESSION['active'] and !($_SESSION['police'])) {
        header("location: landing_page_civ.php");
    }
  }


 ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Website Title -->
  <title>Anti-dote</title>

  <!-- Styles -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/fontawesome-all.css" rel="stylesheet">
  <link href="css/swiper.css" rel="stylesheet">
  <link href="css/magnific-popup.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">

  <!-- Favicon  -->
  <link rel="icon" href="images/logo round.png">
</head>

<body data-spy="scroll" data-target=".fixed-top">

  <!-- Preloader -->
  <div class="spinner-wrapper">
    <div class="spinner">
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div>
  </div>
  <!-- end of preloader -->


  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">

    <!-- Image Logo -->
    <a class="navbar-brand" href="landing_page.php"><img src="images/logo round.png" alt="logo" style="width: 10%"></a>

    <!-- Mobile Menu Toggle Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-awesome fas fa-bars"></span>
      <span class="navbar-toggler-awesome fas fa-times"></span>
    </button>
    <!-- end of mobile menu toggle button -->

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link page-scroll" href="#header">Home <span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item">
          <?php
            if (isset($_SESSION['logged_in'])) {
              if ($_SESSION['logged_in']) {
                echo "<a class='nav-link page-scroll' href='logout.php'>Logout</a>";
              }
              else {
                echo "<a class='nav-link page-scroll' href='index.php'>Login/Signup</a>";
              }
            }
            else {
                echo "<a class='nav-link page-scroll' href='index.php'>Login/Signup</a>";
            }

           ?>
        </li>
      </ul>
    </div>
  </nav> <!-- end of navbar -->
  <!-- end of navigation -->


  <!-- Header -->
  <header id="header" class="header">
    <div class="header-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="text-container">
              <h1><span class="turquoise">.createch's</span><br> Anti-dote</h1>
              <p class="p-large">An app that brings the police and the people together for a united fight.</p>
            </div> <!-- end of text-container -->
          </div> <!-- end of col -->
        </div> <!-- end of row -->
      </div> <!-- end of container -->
    </div> <!-- end of header-content -->
  </header> <!-- end of header -->
  <!-- end of header -->


  <!-- Services -->
  <div id="services" class="cards-1">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2>Services</h2>
          <p class="p-heading p-large">Connecting the police and civilians</p>
        </div> <!-- end of col -->
      </div> <!-- end of row -->
      <div class="row">
        <div class="col-lg-12">

          <!-- Card -->
          <div class="card">
            <img class="card-image" src="images/services-icon-2.svg" alt="alternative">
            <div class="card-body">
              <h4 class="card-title">Locating nearby police & civilians</h4>
              <p>You get access to a list of all the services and requirements, within a 100m radius of you</p>
            </div>
          </div>
          <!-- end of card -->

          <!-- Card -->
          <div class="card">
            <img class="card-image" src="images/services-icon-3.svg" alt="alternative">
            <div class="card-body">
              <h4 class="card-title">Interaction</h4>
              <p>Police officers can personally interact with nearby civilians offering services, via our chat connect</p>
            </div>
          </div>
          <!-- end of card -->

          <!-- Card -->
          <div class="card">
            <img class="card-image" src="images/services-icon-1.svg" alt="alternative">
            <div class="card-body">
              <h4 class="card-title">Common Chat Rooms</h4>
              <p>Every police officer has a public chat room which is automatically accessed by all the nearby civilians</p>
            </div>
          </div>
          <!-- end of card -->

        </div> <!-- end of col -->
      </div> <!-- end of row -->
    </div> <!-- end of container -->
  </div> <!-- end of cards-1 -->
  <!-- end of services -->

  <!-- Details 1 -->
  <div class="basic-1">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="text-container">
            <h2>Idle Resource Utilization</h2>
            <p>Police resources have been limited during this pandemic because they are diverted towards enforcing the extra measures. Our app enables the police to conveniently get access to civilians' not-in-use resources.</p>
          </div> <!-- end of text-container -->
        </div> <!-- end of col -->
        <div class="col-lg-6">
          <div class="image-container">
            <img class="img-fluid" src="images/police fighting covid.jpg" alt="alternative">
          </div> <!-- end of image-container -->
        </div> <!-- end of col -->
      </div> <!-- end of row -->
    </div> <!-- end of container -->
  </div> <!-- end of basic-1 -->
  <!-- end of details 1 -->


  <!-- Details 2 -->
  <div class="basic-2">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="image-container">
            <img class="img-fluid" src="images/police pr.jpg" alt="alternative">
          </div> <!-- end of image-container -->
        </div> <!-- end of col -->
        <div class="col-lg-6">
          <div class="text-container">
            <h2>Police - Community relations</h2>
            <ul class="list-unstyled li-space-lg">
              <li class="media">
                <i class="fas fa-check"></i>
                <div class="media-body">The police staff can award points to civilians for their help</div>
              </li>
              <li class="media">
                <i class="fas fa-check"></i>
                <div class="media-body">The revenue we receive is used towards rewarding the citizens with the highest points</div>
              </li>
              <li class="media">
                <i class="fas fa-check"></i>
                <div class="media-body">Thus encouraging the growth of a healthy relation with the community.</div>
              </li>
            </ul>
          </div> <!-- end of text-container -->
        </div> <!-- end of col -->
      </div> <!-- end of row -->
    </div> <!-- end of container -->
  </div> <!-- end of basic-2 -->
  <!-- end of details 2 -->

  <!-- Details 3 -->
  <div class="basic-1">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="text-container">
            <h2>Reliable</h2>
            <p>In order to gain access to our services, a police officer must be verified, for which we follow a strict process.</p>
          </div> <!-- end of text-container -->
        </div> <!-- end of col -->
        <div class="col-lg-6">
          <div class="image-container">
            <img class="img-fluid" src="images/details-1-office-worker.svg" alt="alternative">
          </div> <!-- end of image-container -->
        </div> <!-- end of col -->
      </div> <!-- end of row -->
    </div> <!-- end of container -->
  </div> <!-- end of basic-1 -->
  <!-- end of details 3 -->

  <!-- Process-->
  <div class="slider-2">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="image-container">
            <img class="img-fluid" src="images/verify.jpg" alt="alternative">
          </div> <!-- end of image-container -->
        </div> <!-- end of col -->
        <div class="col-lg-6">
          <h2>The Verification Process</h2>

          <!-- Card Slider -->
          <div class="slider-container">
            <div class="swiper-container card-slider">
              <div class="swiper-wrapper">

                <!-- Slide -->
                <div class="swiper-slide">
                  <div class="card">
                    <img class="card-image" src="images/badge.png" alt="alternative">
                    <div class="card-body">
                      <p class="testimonial-text">Police Officers need to submit their badge numbers and a picture of their badge during registration</p>
                      <p class="testimonial-author">Step 1</p>
                    </div>
                  </div>
                </div> <!-- end of swiper-slide -->
                <!-- end of slide -->

                <!-- Slide -->
                <div class="swiper-slide">
                  <div class="card">
                    <img class="card-image" src="images/credentials.jpg" alt="alternative">
                    <div class="card-body">
                      <p class="testimonial-text">We personally call up their department to verify their credentials</p>
                      <p class="testimonial-author">Step 2</p>
                    </div>
                  </div>
                </div> <!-- end of swiper-slide -->
                <!-- end of slide -->

                <!-- Slide -->
                <div class="swiper-slide">
                  <div class="card">
                    <img class="card-image" src="images/verified.png" alt="alternative">
                    <div class="card-body">
                      <p class="testimonial-text">Once their records are confirmed, they get access to all our features.</p>
                      <p class="testimonial-author">Step 3</p>
                    </div>
                  </div>
                </div> <!-- end of swiper-slide -->
                <!-- end of slide -->

              </div> <!-- end of swiper-wrapper -->

              <!-- Add Arrows -->
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
              <!-- end of add arrows -->

            </div> <!-- end of swiper-container -->
          </div> <!-- end of slider-container -->
          <!-- end of card slider -->

        </div> <!-- end of col -->
      </div> <!-- end of row -->
    </div> <!-- end of container -->
  </div> <!-- end of slider-2 -->
  <!-- end of Process -->


  <!-- About -->
  <div id="about" class="basic-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2>The Team</h2>
        </div> <!-- end of col -->
      </div> <!-- end of row -->
      <div class="row">
        <div class="col-lg-12">

          <!-- Team Member -->
          <div class="team-member">
            <div class="image-wrapper">
              <img class="img-fluid" src="images/Bhumik.jpg" alt="alternative">
            </div> <!-- end of image-wrapper -->
            <p class="p-large"><strong>Bhumik Bhatia</strong></p>
            <p class="job-title">Designer</p>
          </div> <!-- end of team-member -->
          <!-- end of team member -->

          <!-- Team Member -->
          <div class="team-member">
            <div class="image-wrapper">
              <img class="img-fluid" src="images/Hridiza.jpg" alt="alternative">
            </div> <!-- end of image wrapper -->
            <p class="p-large"><strong>Hridiza Roy</strong></p>
            <p class="job-title">Developer</p>
          </div> <!-- end of team-member -->
          <!-- end of team member -->

          <!-- Team Member -->
          <div class="team-member">
            <div class="image-wrapper">
              <img class="img-fluid" src="images/Aryah.jpg" alt="alternative">
            </div> <!-- end of image wrapper -->
            <p class="p-large"><strong>Aryah Rao</strong></p>
            <p class="job-title">Junior Developer</p>
          </div> <!-- end of team-member -->
          <!-- end of team member -->

        </div> <!-- end of col -->
      </div> <!-- end of row -->
    </div> <!-- end of container -->
  </div> <!-- end of basic-4 -->
  <!-- end of about -->


  <!-- Copyright -->
  <div class="copyright">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p class="p-small">Copyright © 2020 <a href="#">.createch</a> - All rights reserved</p>
        </div> <!-- end of col -->
      </div> <!-- enf of row -->
    </div> <!-- end of container -->
  </div> <!-- end of copyright -->
  <!-- end of copyright -->


  <!-- Scripts -->
  <script src="js/jquery.min.js"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
  <script src="js/popper.min.js"></script> <!-- Popper tooltip library for Bootstrap -->
  <script src="js/bootstrap.min.js"></script> <!-- Bootstrap framework -->
  <script src="js/jquery.easing.min.js"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
  <script src="js/swiper.min.js"></script> <!-- Swiper for image and text sliders -->
  <script src="js/jquery.magnific-popup.js"></script> <!-- Magnific Popup for lightboxes -->
  <script src="js/validator.min.js"></script> <!-- Validator.js - Bootstrap plugin that validates forms -->
  <script src="js/scripts.js"></script> <!-- Custom scripts -->
</body>

</html>
