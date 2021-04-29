<?php
    require 'db.php';
    session_start();

    //Checking if logged in
    if ( isset($_SESSION['logged_in']) ) {
        if($_SESSION['logged_in'] != true){
            $_SESSION['message'] = "Sorry. You're not logged in.";
            header("location: error.php");
        }
    }
    else {
        $_SESSION['message'] = "Sorry. You're not logged in.";
        header("location: error.php");
    }

    if (!($_SESSION['active'] and $_SESSION['verified'])) {
      header("location: landing_page.php");
    }

    $email = $_SESSION['email'];

    if (isset($_POST['Add'])) {

        $lat = $_POST['lat'];
        $long = $_POST['long'];

        //Coordinates in radians
        $lat_rad = $lat*pi()/180;
        $long_rad = $long*pi()/180;

        function dist($latitude, $longitude) {
            global $lat_rad, $long_rad;

            $latitude = $latitude*pi()/180;
            $longitude = $longitude*pi()/180;

            $R = 6.371*pow(10, 6); //Radius of Earth in metres
            $a = sin( ($latitude - $lat_rad)/2 )*sin( ($latitude - $lat_rad)/2 ) + cos($lat_rad)*cos($latitude)*sin( ($longitude - $long_rad)/2 )*sin( ($longitude - $long_rad)/2 );
            $c = 2*atan2( sqrt($a), sqrt(1-$a) ); //Returns angle from x and y coordinate values
            $d = $R*$c; //Distance between the 2 points

            return $d;
        }

        if ($_POST['type'] == 'product') {
            $type = 1;
        }
        else {
            $type = 0;
        }

        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $expiry = $_POST['exp'];

        $sql = "INSERT INTO reqs (pType, title, descript, expiry, email)" . " VALUES ('$type', '$title', '$desc', '$expiry', '$email')";

        if ( $mysqli->query($sql) ){
            //Getting users within radius
            $setLocation = $mysqli->query("UPDATE police SET latitude = $lat, longitude = $long WHERE email = '$email'");
            $getUsers = $mysqli->query("SELECT * FROM civilians");

            $users = array();

            if ($getUsers != false) {

                while($row = $getUsers->fetch_assoc()){
                    if (dist($row['latitude'], $row['longitude']) <= $radius) {
                        $user = $row['email'];
                        array_push($users, "$user");
                    }
                }

                foreach ($users as $user) {
                    $subject = "New Product/Service Request near you! (Anti-dote)";
                    $message_body = "Title: $title
                    Description: $desc
                    Expiry: $expiry";
                    mail($user, $subject, $message_body);
                }
            }
            header("location: landing_page.php");
        }
        else {
            $_SESSION['message'] = "Request could not be registered.";
            header("location: error.php");
        }
    }

    $API_KEY = "AIzaSyD9bijpOpTAWO69lpuQpkmgkZmgkJZq1eo";

?>

<html>

<head>
    <title>Add Request</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/fontawesome-all.css" rel="stylesheet">
    <link href="css/swiper.css" rel="stylesheet">
    <link href="css/magnific-popup.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-indigo.min.css" />
    
    <link rel="icon" href="images/logo round.png">

    <style>
        body {
          background-image: url("images/header-background.jpg");
          background-size: cover;
          background-repeat: no-repeat;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
        label, input {
            display: block;
        }
        textarea {
            font-family: 'lato', helvetica;
            font-size: 1.3em;
            line-height: 1.5;
        }
        input[type=text] {
          font-family: 'lato', helvetica;
          font-size: 1.3em;
          line-height: 1.5;
        }
        .add {
          font-size: 1.5em;
          display: block;
          margin: 2% 0;
        }
        form {
          margin: 2%;
        }
        .radius, .addreqserv, .coords, .search, .logout, .home {
            margin: 0.5% 2%;
        }
    </style>
</head>

<body>

  <form method = "post" action = "addRequest.php">

    <input type="radio" id="product" name="type" value="product" style="display: inline">
    <span>Product</span><br><br>
    <input type="radio" id="service" name="type" value="service" style="display: inline">
    <span>Service</span><br><br>

    <div class="form-group">
      <input type = "text" required name = "title" class = "title form-control-input">
      <label class="label-control" for = "title">Title</label>
      <div class="help-block with-errors"></div>
    </div>

    <div class="form-group">
      <textarea type = "text" name = "desc" rows = "5" cols = "100" id = "desc" required class="form-control-textarea"></textarea>
      <label for = "desc" class="label-control">Description</label>
      <div class="help-block with-errors"></div>
    </div>

      <label for="exp">Required by:</label>
      <input type="date" id="exp" name="exp" required>

      <input type = "text" hidden name = "lat" id = "lat">
      <input type="text" hidden name = "long" id = "long">

      <div class="form-group">
        <input type = "submit" value = "Add" class = "add form-control-submit-button" name = "Add">
      </div>
      <p class = "errMsg"></p>

  </form>

  <p class="home"><a href = "landing_page.php">Home</a></p>
  <p class="logout"><a href = "logout.php">Log out</a></p>

    <script
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo $API_KEY; ?>&callback=initMap"
      async defer></script>

    <script>

        var lat;
        var long;

        function locate(){
            if ("geolocation" in navigator){
                navigator.geolocation.getCurrentPosition(function(position){
                    var currentLatitude = position.coords.latitude;
                    var currentLongitude = position.coords.longitude;

                    lat = currentLatitude;
                    long = currentLongitude;

                    document.getElementById("lat").value = lat;
                    document.getElementById("long").value = long;
                });
            }
        }

        locate();

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;

        document.getElementById('exp').min = today;
        document.getElementById('exp').value = today;

    </script>

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
