<?php
    require 'db.php';
    session_start();
    //Checking if logged in
    if ( isset($_SESSION['logged_in']) ) {
      if($_SESSION['logged_in'] == true){
          header("location: landing_page.php");
      }
    }

?>

<html>
    <head>
        <title>Login/Sign Up</title>

        <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-indigo.min.css" />
        <link href="css/login.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
        
        <link rel="icon" href="images/logo round.png">

        <style>
        /*Hiding all the forms at Load*/
        #signup_police {
          display: none;
        }

        #signup_civilian {
          display: none;
        }
        .clickables {
          display: inline;
          width: 25%;
          text-align: center;
          font-size: large;
        }
        .button {
          width: 100%;
          text-align: center;
        }
        </style>
    </head>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['login'])) {
        require 'login.php';
    }
    elseif (isset($_POST['register_police'])) {
        require 'register_police.php';
    }
    elseif (isset($_POST['register_civilian'])) {
        require 'register_civilian.php';
    }
}

?>


<body>
  <div class = "button">
          <button id = "login_button" class = "clickables"> Login </button>
          <button id = "register_police_button" class = "clickables"> Register As Police </button>
          <button id = "register_civilian_button" class = "clickables"> Register As Civilian </button>

  </div>


    <div class = "form" id = "form">

        <div class = "tab-content">
        <!--Login-->
            <div id = "login">
              <div class="container">
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
            </div>

        <!--Signup as police-->
            <div id = "signup_police" class = "bodyreg">
              <div class="container">

                <h1>Sign Up for Free!</h1>

                <form action = "index.php" method = "post" autocomplete = "off" enctype="multipart/form-data">

                    <div class = "top-row">
                        <div class = "field-wrap">
                            <input type = "text" required autocomplete = "off" name = 'firstname' placeholder = "First Name*">
                        </div>

                        <div class = "field-wrap">
                            <input type = "text" required autocomplete = "off" name = "lastname" placeholder = "Last Name*">
                        </div>

                        <div class = "field-wrap">
                            <input id = "date_field_1" type = "date" required autocomplete = "off" name = "DOB" placeholder = "Date of Birth*">
                        </div>
                        <div class = "field-wrap">
                            <input type = "text" required autocomplete = "off" name = "mobile" placeholder = "Mobile*" pattern="[0-9]{10}" title="10 Digit Mobile Number">
                        </div>

                        <div class = "field-wrap">
                            <input type = "text" required autocomplete = "off" name = "post" placeholder = "Post*">
                        </div>

                        <div class = "field-wrap">
                            <label for="policestation">Police Station:</label>

                            <select name="policestation">
                                <optgroup label = "District Central">
                                    <option value="Bara Hindu Rao Police Station">Bara Hindu Rao Police Station</option>
                                    <option value="Burari Police Station">Burari Police Station</option>
                                    <option value="Chandni Mahal Police Station">Chandni Mahal Police Station</option>
                                    <option value="Civil Lines Police Station">Civil Lines Police Station</option>
                                    <option value="Companies Act">Companies Act</option>
                                    <option value="Darya Ganj Police Station">Darya Ganj Police Station</option>
                                    <option value="DBG Road Police Station">DBG Road Police Station</option>
                                    <option value="Delhi Cantt. Railway Police Station">Delhi Cantt. Railway Police Station</option>
                                    <option value="Gulabi Bagh Police Station">Gulabi Bagh Police Station</option>
                                    <option value="Bara Hindu Rao Police Station">Bara Hindu Rao Police Station</option>
                                </optgroup>

                                <optgroup label = "District West">
                                    <option value="Anand Parbat Police Station">Anand Parbat Police Station</option>
                                    <option value="Hari Nagar Police Station">Hari Nagar Police Station</option>
                                    <option value="Janak Puri Metro Police Station">Janak Puri Metro Police Station</option>
                                    <option value="Khyala Police Station">Khyala Police Station</option>
                                    <option value="Kirti Nagar Police Station">Kirti Nagar Police Station</option>
                                </optgroup>

                                <optgroup label = "District East">
                                    <option value="Gandhi Nagar Police Station">Gandhi Nagar Police Station</option>
                                    <option value="Gazi Pur Police Station">Gazi Pur Police Station</option>
                                    <option value="Geeta Colony Police Station">Geeta Colony Police Station</option>
                                    <option value="Kalyan Puri Police Station">Kalyan Puri Police Station</option>
                                    <option value="Krishna Nagar Police Station">Krishna Nagar Police Station</option>
                                    <option value="Mandawali Police Station">Mandawali Police Station</option>
                                </optgroup>

                                <optgroup label = "District North-East">
                                    <option value="Bhajan Pura Police Station">Bhajan Pura Police Station</option>
                                    <option value="Gokul Puri Police Station">Gokul Puri Police Station</option>
                                    <option value="Karawal Nagar Police Station">Karawal Nagar Police Station</option>
                                    <option value="Khajoori Khas Police Station">Khajoori Khas Police Station</option>
                                    <option value="New Usman Pur Police Station">New Usman Pur Police Station</option>
                                    <option value="Seelampur Police Station">Seelampur Police Station</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class = "field-wrap">
                            <input type = "text" required autocomplete = "off" name = "badgenumber" placeholder = "Badge number*" pattern="[0-9]{1,}">
                        </div>

                        <div class = "field-wrap">
                            <input type="file" required name = "badgeimage">
                        </div>
                    </div>

                    <div class = "field-wrap">
                        <input type = "email" required autocomplete = "off" name = "email" placeholder = "Email*">
                    </div>

                    <div class = "field-wrap">
                        <input type = "password" required autocomplete = "off" name = "password" placeholder = "Set A Password*">
                    </div>

                     <button class = "button button-block registerbtn" name = "register_police">Sign Up</button>
                </form>
              </div>
            </div>

        <!--Signup as civilian-->
            <div id = "signup_civilian" class = "bodyreg">
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

                        <div class = "field-wrap">
                            <input id = "date_field_2" type = "date" required autocomplete = "off" name = "DOB" placeholder = "Date of Birth*">
                        </div>
                        <div class = "field-wrap">
                            <input type = "text" required autocomplete = "off" name = "aadhar" placeholder = "Aadhar*" pattern="[0-9]{12}" title="12 Digit Aadhar Number">
                        </div>
                    </div>

                    <div class = "field-wrap">
                        <input type = "email" required autocomplete = "off" name = "email" placeholder = "Email*">
                    </div>

                    <div class = "field-wrap">
                        <input type = "password" required autocomplete = "off" name = "password" placeholder = "Set A Password*">
                    </div>

                     <button class = "button button-block registerbtn" name = "register_civilian">Sign Up</button>
                </form>
              </div>
            </div>

        </div>
    </div>


    <script>


        var x = document.getElementById("login");
        var y = document.getElementById("signup_police");
        var z = document.getElementById("signup_civilian");
        var a = document.getElementById("login_button");
        var b = document.getElementById("register_police_button");
        var c = document.getElementById("register_civilian_button");

        document.getElementById("login_button").addEventListener("click", login_function);
        document.getElementById("register_police_button").addEventListener("click", police_function);
        document.getElementById("register_civilian_button").addEventListener("click", civilian_function);

        function login_function() {
            x.style.display = "block";
            y.style.display = "none";
            z.style.display = "none";
            a.style.backgroundColor = "darkGreen";
            b.style.backgroundColor = "#4caf50";
            c.style.backgroundColor = "#4caf50";
        }

        function police_function() {
          x.style.display = "none";
          y.style.display = "block";
          z.style.display = "none";
          a.style.backgroundColor = "#4caf50";
          b.style.backgroundColor = "darkGreen";
          c.style.backgroundColor = "#4caf50";
        }

        function civilian_function() {
          x.style.display = "none";
          y.style.display = "none";
          z.style.display = "block";
          a.style.backgroundColor = "#4caf50";
          b.style.backgroundColor = "#4caf50";
          c.style.backgroundColor = "darkGreen";
        }

        function date_max() {

          //Max date to today
          var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth()+1;
          var yyyy = today.getFullYear();
          if(dd<10){
            dd='0'+dd
          }
          if(mm<10){
            mm='0'+mm
          }
          today = yyyy+'-'+mm+'-'+dd;
          document.getElementById("date_field_1").setAttribute("max", today);
          document.getElementById("date_field_2").setAttribute("max", today);
          a.style.backgroundColor = "darkGreen";
        }

        date_max();


    </script>
</body>
</html>
