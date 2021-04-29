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

    $fileDir = "chats/";

    if (isset($_POST['add'])) {
        global $fileDir;
            
        $thread = $_POST['thread'].".txt";

        $_SESSION['thread'] = $thread;

        $createFile = fopen($fileDir.$thread, "w");

        fclose($createFile);

        header("location: commonChats.php");
    }

?>

<html>

<head>
    <title>Add chat thread</title>
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

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        label, input {
            display: block;
        }
        input[type=text] {
            font-family: 'lato', helvetica;
            font-size: 1.3em;
            line-height: 1.5;
        }

        form, .errMsg, .check, p{
            margin: 2%;
        }
        .add {
            margin: 2% 0;
            width: 10%;
        }
    </style>
</head>

<body>

<form method = "post">
    <label for = "thread">Thread Name</label>
    <input type = "text" required name = "thread" class = "thread">

    <input type = "submit" value = "Add Thread" class = "add mdl-button mdl-js-button mdl-button--raised mdl-color--primary" name = "add">
    <p class = "errMsg"></p>
</form>

    <p><a href = "home.php">Home</a></p>
    <p><a href = "logout.php">Log out</a></p>

    <script>
        document.querySelector('.thread').addEventListener('input', check);

        function check() {

            const params = "thread=" + this.value;

            var xhttp = new XMLHttpRequest();
            var url = "checkThreadName.php";
            xhttp.open("POST", url, true);

            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (xhttp.responseText == "0") {
                        document.querySelector('.errMsg').innerHTML = "Thread already exists";
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
    </script>

</body>

</html>