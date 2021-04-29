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

    if($_SESSION['police']){
      if (!($_SESSION['active'] and $_SESSION['verified'])) {
        header("location: landing_page.php");
      }
    }
    else {
      if (!($_SESSION['active'])) {
        header("location: landing_page.php");
      }
    }

    $API_KEY = "AIzaSyD9bijpOpTAWO69lpuQpkmgkZmgkJZq1eo";

?>
<html>
    <head>

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
        .prods .user {
            cursor: pointer;
        }
        button a{
            color: #fff;
            text-decoration: none;
        }

        .radius {
          padding: 0.5%;
          font-size: 1.2em;
        }

        .radius, .addreqserv, .coords, .search, .logout, .home, .prods {
            margin: 0.5% 1%;
        }

        .prod {
          padding: 1%;
          width: max-content;
        }

        .prod p {
          padding: 1% 3%;
          width: max-content;
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

    </style>
    </head>
    <body>

    <div class = "coords"></div>
    <?php
        if ($_SESSION['police']) {
            echo '<input type = "number" name = "radius" value = "100" class = "radius" placeholder = "Radius* (in meters)"><br>';
        }
     ?>

    <div class = "prods"></div>

    <?php
        if ($_SESSION['police']) {
            echo '<button id = "req" class = "mdl-button mdl-js-button mdl-button--raised mdl-color--primary addreqserv"><a href = "addRequest.php">Request Product or Service</a></button>';
        }
        else {
            echo '<button id = "add" class = "mdl-button mdl-js-button mdl-button--raised mdl-color--primary addreqserv"><a href = "addProdOrServ.php">Add Product or Service</a></button>';
        }
    ?>

    <br>

    <button class = "mdl-button mdl-js-button mdl-button--raised mdl-color--primary search"><a href = "searchQ.php">Search</a></button><br>

    <br>

    <p class="home"><a href = "landing_page.php">Home</a></p>
    <p class="logout"><a href = "logout.php">Log out</a></p>


    <form action = "deal.php" method = "POST" id = "deal" hidden>
        <input type = "text" name = "to" id = "to" hidden>
    </form>


    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $API_KEY; ?>&callback=initMap"
        async defer></script>
    <script type="text/javascript">

        var lat;
        var long;

        function locate(){
            if ("geolocation" in navigator){
                navigator.geolocation.getCurrentPosition(function(position){
                    var currentLatitude = position.coords.latitude;
                    var currentLongitude = position.coords.longitude;

                    lat = currentLatitude;
                    long = currentLongitude;

                    document.querySelector(".coords").innerHTML = `Latitude: ${lat}, Longitude: ${long}`;

                    setActive();
                });
            }
        }

        function setActive() {

            const params = "lat=" + lat + "&long=" + long;

            var xhttp = new XMLHttpRequest();
            var url = "activeMembers.php";
            xhttp.open("POST", url, true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    getUsers();
                }
            };
            xhttp.send(params);
        }

        function getUsers() {
            try {
              if (document.querySelector('.radius').value > 0) {
                var radius = document.querySelector('.radius').value;
              }
              else {
                var radius = 100;
              }
            }
            catch(e) {
              var radius = 100;
            }

            const params = "lat=" + lat + "&long=" + long + "&radius=" + radius;

            var xhttp = new XMLHttpRequest();
            var url = "getUsers.php";
            xhttp.open("POST", url, true);

            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (xhttp.response != document.querySelector('.prods').innerHTML) {
                        document.querySelector('.prods').innerHTML = xhttp.response;
                        userListeners();
                    }
                }
            };
            xhttp.send(params);
        }

        function userListeners() {

            var persons = document.querySelectorAll(".prods .user");

            for ( var i = 0; i < persons.length; i++) {
                persons[i].addEventListener('click', open);
            }
        }

        function open() {
            document.getElementById('to').value = this.innerText;
            document.getElementById('deal').submit();
        }

        setInterval(locate, 1000);
        <?php
        if ($_SESSION['police']){
          echo "document.querySelector('.radius').addEventListener('input', getUsers)";
        }
         ?>


    </script>

    </body>

</html>
