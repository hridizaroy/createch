
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

    $username = $_SESSION['username'];

    $files = listThreads();

    function listThreads() {
        
        $fileDir = "chats/";

        $filesList = array();

        if($handle = opendir($fileDir)) {
            while ($entry = readdir($handle)) {
                if ( $entry != "."  && $entry != ".." & $entry != ".txt" ){
                    $entry = explode(".txt", $entry)[0];
                    array_push($filesList, $entry);
                }
            }
            closedir($handle);
        }

        return $filesList;
    }

?>


<html>
    <head>
        <title>Chat Threads</title>

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

        .files {
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
            color: #fff;
            margin: 1% 3%;
        }

        li {
            cursor: pointer;
            font-size: 1.2em;
        }

        form, .errMsg, .check, p{
            margin: 2%;
        }
    </style>
    </head>
    <body>

        <!--Files-->
        <ul class = "files">
        <?php
            for ( $i = 0; $i < count($files); $i++ ) {
                echo "<li>".$files[$i]."</li>";
            }
            if (count($files) == 0) {
                echo "<p>No chat threads yet</p>";
            }
        ?>
        </ul>
        <!--New File Button-->
        <button class = "newFile mdl-button mdl-js-button mdl-button--raised mdl-color--red"><a href = "addChatThread.php">New Thread</a></button>

        <p><a href = "home.php">Home</a></p>
        <p><a href = "logout.php">Log out</a></p>


        <form action = "commonChats.php" target = "commonChats.php" method = "POST" id = "threadCont" hidden>
            <input type = "text" name = "thread" id = "thread" hidden>
        </form>


        <script>

            var files = document.querySelectorAll(".files li");

            for ( var i = 0; i < files.length; i++) {
                files[i].addEventListener('click', open);
            }

            function open() {
                document.getElementById('thread').value = this.innerText;
                document.getElementById('threadCont').submit();
            }



        </script>

    </body>
</html>