
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

    $email = $_SESSION['email'];

    $files = listThreads();

    function listThreads() {

        global $email;

        $fileDir = "$email/chats/";

        $filesList = array();

        if($handle = opendir($fileDir)) {
            while ($entry = readdir($handle)) {
                if ( $entry != "." and $entry != ".." and $entry != ".txt" and $entry != "public.txt" ){
                    $entry = explode(".txt", $entry)[0];
                    array_push($filesList, $entry);
                }
            }
            closedir($handle);
        }

        return $filesList;
    }

    if (!($_SESSION['police'])){
      $radius = 100;

      $coords = $mysqli->query("SELECT latitude, longitude from civilians WHERE email = '$email'");
      $coords = $coords->fetch_assoc();

      $lat = $coords['latitude'];
      $long = $coords['longitude'];

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

      //Getting users within radius
      $getUsers = $mysqli->query("SELECT * FROM police WHERE verified = 1 and active = 1");

      $users = array();

      if ($getUsers != false) {

        while($row = $getUsers->fetch_assoc()){
            if (dist($row['latitude'], $row['longitude']) <= $radius) {
                $user = $row['email'];
                array_push($users, "$user");
            }
        }
      }
    }

?>


<html>
    <head>
        <title>Chat Threads</title>

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
        .files, .public_threads {
            margin: 3%;
        }

        .newFile a {
            color: #fff;
            text-decoration: none;
        }

        ul {
            position: relative;
            list-style: none;
        }

        li::before {
            content: '▶';
            position: absolute;
            left: 0;
        }

        .newFile {
            margin: auto;
            font-size: 1.5em;
        }

        li {
            cursor: pointer;
            font-size: 1.2em;
        }

        form, .errMsg, .check, p{
            margin: 2%;
        }
        .radius, .addreqserv, .coords, .search, .logout, .home {
            margin: 0.5% 2%;
        }
    </style>
    </head>
    <body>

        <!--Files-->
        <ul class = "files">
        <?php
            echo "<h3>Personal Chats</h3>";
            for ( $i = 0; $i < count($files); $i++ ) {
                echo "<li>".$files[$i]."</li>";
            }
            if (count($files) == 0) {
                echo "<p>No chat threads yet</p>";
            }
        ?>
        </ul>

        <ul class="public_threads">
          <?php
            if (!($_SESSION['police'])){
              echo "<h3>Public Threads</h3>";
              for ( $i = 0; $i < count($users); $i++ ) {
                  echo "<li>".$users[$i]."</li>";
              }
              if (count($users) == 0) {
                  echo "<p>No Public Chat threads available right now</p>";
              }
            }
           ?>
        </ul>

        <p class="home"><a href = "landing_page.php">Home</a></p>
        <p class="logout"><a href = "logout.php">Log out</a></p>


        <form action = "deal.php" target = "deal.php" method = "POST" id = "threadCont" hidden>
            <input type = "text" name = "to" id = "thread" hidden>
        </form>

        <form action = "public_chat.php" target = "public_chat.php" method = "POST" id = "thread_public_cont" hidden>
            <input type = "text" name = "officer" id = "thread_public" hidden>
        </form>

        <script>

            var files = document.querySelectorAll(".files li");
            var officers = document.querySelectorAll(".public_threads li");

            for ( var i = 0; i < files.length; i++) {
                files[i].addEventListener('click', open);
            }


            for ( var i = 0; i < officers.length; i++) {
                officers[i].addEventListener('click', open_public);
            }

            function open() {
                document.getElementById('thread').value = this.innerText;
                document.getElementById('threadCont').submit();
            }

            function open_public() {
                document.getElementById('thread_public').value = this.innerText;
                document.getElementById('thread_public_cont').submit();
            }


        </script>

    </body>
</html>
