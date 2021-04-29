<?php
    require 'db.php';
    session_start();

    //Checking if logged in
    if ( isset($_SESSION['logged_in']) ) {
      if($_SESSION['logged_in'] == true){
          header("location: home - loggedIn.php");
      }
    }

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- SEO Meta Tags -->
  <meta name="description" content="RemoteCollaboration">
  <meta name="author" content="Bhumik">

  <meta property="og:site_name" content="" />
  <meta property="og:site" content="" />
  <meta property="og:title" content="" />
  <meta property="og:description" content="" />
  <meta property="og:image" content="" />
  <meta property="og:url" content="" />
  <meta property="og:type" content="article" />

  <!-- Website Title -->
  <title>Ctrl+S</title>

  <!-- Styles -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/fontawesome-all.css" rel="stylesheet">
  <link href="css/swiper.css" rel="stylesheet">
  <link href="css/magnific-popup.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">

  <!-- Favicon  -->
  <link rel="icon" href="images/favicon.png">
  <style>    
    #logo {
      height: 10%;
    }
    </style>
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
  <!-- Navigation -->
  <nav class="navbar navbar-expand-md navbar-dark navbar-custom fixed-top">

    <a class="navbar-brand logo-image" href="home.php"><img src="logo.png" alt="Logo" id="logo"></a>
    <h1>Ctrl+S</h1>

    <!-- Mobile Menu Toggle Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-awesome fas fa-bars"></span>
      <span class="navbar-toggler-awesome fas fa-times"></span>
    </button>
    <!-- end of mobile menu toggle button -->

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link page-scroll" href="#header">HOME <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link page-scroll" href="index.php">LOG IN/SIGN UP</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- end of navigation -->

  <!-- Header -->
  <header id="header" class="header">
    <div class="header-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="text-container">
              <h1><span id="js-rotating">Break, Bond, Perspective</span></h1>
              <p class="p-large">Work is important, but staring at a screen for hours? We know you need a break, and we're here for you.<br>
Ctrl+S: A Real-time shared-file editing and project management app, with a twist!</p>
            </div>
          </div> <!-- end of col -->
        </div> <!-- end of row -->
      </div> <!-- end of container -->
    </div> <!-- end of header-content -->
  </header> <!-- end of header -->
  <!-- end of header -->


  <!-- Features -->
  <div id="features" class="tabs">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2>FEATURES</h2>
          <div class="p-heading p-large">
          
          Ctrl+S analyzes the contents of the project you're working on, 
          and generates games based on the contents, for you to play with your teammates!
        
        </div>
        </div> <!-- end of col -->
      </div> <!-- end of row -->
      <div class="row">


        <!-- Tabs Content-->
        <div class="tab-content" id="lenoTabsContent">

          <!-- Tab -->
          <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1">
            <div class="container">
              <div class="row">

                <!-- Icon Cards Pane -->
                <div class="col-lg-4" style="text-align: center; margin:auto;">
                  <div class="card right-pane first">
                    <div class="card-body">
                      <div class="card-icon">
                        <i class="fas fa-users"></i>
                      </div>
                      <div class="text-wrapper">
                        <h4 class="card-title">Make teams</h4>
                        <p>Add as many people as you want to a team by their usernames</p>
                      </div>
                    </div>
                  </div>
                  <div class="card right-pane">
                    <div class="card-body">
                      <div class="card-icon">
                        <i class="far fa-file"></i>
                      </div>
                      <div class="text-wrapper">
                        <h4 class="card-title">Add projects</h4>
                        <p>Add projects team-wise, and get a chat-window for each individual project.</p>
                      </div>
                    </div>
                  </div>
                  <div class="card right-pane">
                    <div class="card-body">
                      <div class="card-icon">
                        <i class="far fa-compass"></i>
                      </div>
                      <div class="text-wrapper">
                        <h4 class="card-title">Edit files in real time</h4>
                        <p>Your entire team can edit the same file at the same time.</p>
                      </div>
                    </div>
                  </div>
                  <div class="card right-pane">
                    <div class="card-body">
                      <div class="card-icon">
                        <i class="fas fa-users"></i>
                      </div>
                      <div class="text-wrapper">
                        <h4 class="card-title">Play games based on your project content!</h4>
                        <p>Get auto-generated customized games based on your work, and play with your teammates! According to the researchers at Brigham Young University, playing games for 45 minutes with coworkers can improve
                        productivity by 20%</p>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end of icon cards pane -->

              </div> <!-- end of row -->
            </div> <!-- end of container -->
          </div> <!-- end of tab-pane -->
          <!-- end of tab -->

        </div> <!-- end of tab-content -->
        <!-- end of tabs content -->

      </div> <!-- end of row -->
    </div> <!-- end of container -->
  </div> <!-- end of tabs -->
  <!-- end of features -->



  <!-- Details 1 -->
  <div id="details" class="basic-2">
  
    <h2 style = "text-align: center; margin-top: -3%; margin-bottom: 8%;">BENEFITS</h2>


    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <img class="img-fluid" src="ss1.PNG" alt="alternative">
        </div> <!-- end of col -->
        <div class="col-lg-6">
          <div class="text-container">
            <h3>Break</h3>
            <p>Playing a game from time to time, you get a break from your constant work, helping in stress management</p>
          </div> <!-- end of text-container -->
        </div> <!-- end of col -->
      </div> <!-- end of row -->
    </div> <!-- end of container -->
  </div> <!-- end of basic-2 -->
  <!-- end of details 1 -->


  <!-- Details 2 -->
  <div class="basic-3">
    <div class="second">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="text-container">
              <h3>Bond</h3>
              <p>The games are targeted at team bonding, so you no longer have to worry about remote workers getting less bonding opportunities with their teammates. We've got you covered.</p>
            </div> <!-- end of text-container -->
          </div> <!-- end of col -->
          <div class="col-lg-6">
            <img class="img-fluid" src="ss2.PNG" alt="alternative">
          </div> <!-- end of col -->
        </div> <!-- end of row -->
      </div> <!-- end of container -->
    </div> <!-- end of second -->
  </div> <!-- end of basic-3 -->
  <!-- end of details 2 -->

    <!-- Details 3 -->
    <div class="basic-3">
      <div class="second">
        <div class="container">
          <div class="row">
                        <div class="col-lg-6">
                          <img class="img-fluid" src="ss3.PNG" alt="alternative">
                        </div> <!-- end of col -->
            <div class="col-lg-6">
              
              <div class="text-container">
                <h3>Perspective</h3>
                <p>Since the games are based on your project contents, you get a new perspective on what you're working on</p>
              </div> <!-- end of text-container -->
            </div> <!-- end of col -->

          </div> <!-- end of row -->
        </div> <!-- end of container -->
      </div> <!-- end of second -->
    </div> <!-- end of basic-3 -->
    <!-- end of details 3 -->


  <!-- Scripts -->
  <script src="js/jquery.min.js"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
  <script src="js/popper.min.js"></script> <!-- Popper tooltip library for Bootstrap -->
  <script src="js/bootstrap.min.js"></script> <!-- Bootstrap framework -->
  <script src="js/jquery.easing.min.js"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
  <script src="js/swiper.min.js"></script> <!-- Swiper for image and text sliders -->
  <script src="js/jquery.magnific-popup.js"></script> <!-- Magnific Popup for lightboxes -->
  <script src="js/morphext.min.js"></script> <!-- Morphtext rotating text in the header -->
  <script src="js/validator.min.js"></script> <!-- Validator.js - Bootstrap plugin that validates forms -->
  <script src="js/scripts.js"></script> <!-- Custom scripts -->
</body>

</html>
