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

<html>
    <head>
        <title>Ctrl+S Login/Sign Up</title>
          <!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="yes">
<link rel="icon" sizes="192x192" href="images/android-desktop.png">

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="The Dreamweavers Charitable Trust">
<link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

<!-- Tile icon for Win8 (144x144 + tile color) -->
<meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
<meta name="msapplication-TileColor" content="#3372DF">

<link rel="shortcut icon" href="images/favicon.png">

<link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-indigo.min.css" />
        <link href="css/login.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
    </head>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['login'])) {
        require 'login.php';
    }
    elseif (isset($_POST['register'])) {
        require 'register.php';
    }
}

?>


<body>
    <div class = "form" id = "form">

        <div class = "tab-content">

          <div class="imgcontainer">
            <img src="logo.png" alt="Logo" style = "height: 20%;">
          </div>

            <div id = "login">

                <h1>Welcome Back!</h1>

                <form action = "index.php" method = "post" autocomplete = "off">
                  <div class = 'container'>
                    <div class = "field-wrap">
                        <input type = "email" required autocomplete = "off" name = "email" placeholder = "Email Address*">
                    </div>

                    <div class = "field-wrap">
                        <input type = "password" required autocomplete = "off" name = "password" placeholder = "Password*">
                    </div>
                  </div>

                    <button class = "button button-block" name = "login">Login</button>
                </form>
            </div>

            <div id = "signup" class = "bodyreg">
              <div class="container">

                <h1>Sign Up for Free!</h1>

                <form action = "index.php" method = "post" autocomplete = "off">

                    <div class = "top-row">
                        <div class = "field-wrap">
                            <input type = "text" required autocomplete = "off" name = 'firstname' placeholder = "First Name*">
                        </div>

                        <div class = "field-wrap">
                            <input type = "text" required autocomplete = "off" name = "lastname" placeholder = "Last Name*">
                        </div>
                    </div>

                    <div class = "field-wrap">
                        <input type = "email" required autocomplete = "off" name = "email" placeholder = "Email*">
                    </div>

                    <div class = "field-wrap">
                        <input type = "text" required autocomplete = "off" name = 'username' placeholder = "Set a Username*">
                    </div>

                    <div class = "field-wrap">
                        <input type = "password" required autocomplete = "off" name = "password" placeholder = "Set A Password*">
                    </div>

                     <button class = "button button-block registerbtn" name = "register">Sign Up</button>
                </form>
              </div>
            </div>
        </div>
    </div>


    <script>
        function login() {
            document.getElementById('signup').style.display = "none";
            document.getElementById('login').style.display = "block";

        }

        function signup() {
            document.getElementById('signup').style.display = "block";
            document.getElementById('login').style.display = "none";
        }

        document.getElementById('loginlink').addEventListener('click', login);
        document.getElementById('signuplink').addEventListener('click', signup);


    </script>
</body>
</html>
