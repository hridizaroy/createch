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

    require 'functions.php';

    if (isset($_POST['teamName'])) {
        $_SESSION['teamName'] = $_POST['teamName'];
    }

    //Adding Project
    $username = $_SESSION['username'];

    if (isset($_POST['addProject'])) {
        $projName = $_POST['projName'];
        $fileName = $_SESSION['teamName']."/$projName/files";
        $forChats = $_SESSION['teamName']."/$projName/chats";
        //$forSites = $_SESSION['teamName']."/$projName/sites";
        if (mkdir("$fileName", 0777, true)) {
            if (mkdir("$forChats", 0777, true)) {
               // if (mkdir("$forSites", 0777, true)) {
                    $_SESSION['projectName'] = $projName;
                    header("location: newfile.php");
                //}
            }
        }
    }


?>

<html>

<head>
    <title>Add Project Ctrl+S</title>
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
  <link rel="stylesheet" href="styles.css">
    <style>
        label, input {
            display: block;
        }
        input[type=text] {
          font-family: 'lato', helvetica;
          font-size: 1.3em;
          line-height: 1.5;
        }
        .add {
          display: block;
          margin: 2% 0;
        }
        form, p {
          margin: 2%;
        }
    </style>
</head>

<body>

    <form method = "post">

        <div class = "addingProject">

            <label for = "projectName">Project Name</label>
            <input type = "text" name = "projName" required class = "projectName">

            <input type = "submit" name = "addProject" value = "Add" class = "add mdl-button mdl-js-button mdl-button--raised mdl-color--primary">
        </div>

    </form>

    <p class = "errMsg"></p>

    <p><a href = "home.php">Home</a></p>
    <p><a href = "logout.php">Log out</a></p>

    <script>

        function check() {

            const params = "projectName=" + this.value;

            var xhttp = new XMLHttpRequest();
            var url = "checkProjectName.php";
            xhttp.open("POST", url, true);

            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (xhttp.responseText == "0") {
                        document.querySelector('.errMsg').innerHTML = "Project name already exists";
                        document.querySelector('.add').style.display = "none";
                    }
                    else if (xhttp.responseText == "1"){
                        document.querySelector('.errMsg').innerHTML = "";
                        document.querySelector('.add').style.display = "block";
                    }
                }
            };
            xhttp.send(params);
        }

        document.querySelector(".projectName").addEventListener('input', check);


    </script>

</body>


</html>
