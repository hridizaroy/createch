<?php
    session_start();
    $home = "home.php";
?>

<html>
    <head>
        <title>Error</title>
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
      .form {
        margin: 2%;
      }
      </style>
    </head>
    <body>
        <div class = "form">
            <h1>Error</h1>
            <p class = "err">
                <?php
                if (isset($_SESSION['message']) AND !empty($_SESSION['message']) ):
                    echo $_SESSION['message'];
                else:
                    header( "location: home.php");
                endif;
                ?>
                </p>
                <a href = "<?php echo $home;?>" class = "home"><button class = "button button-block mdl-button mdl-js-button mdl-button--raised mdl-color--primary">Home</button></a>
        </div>
    </body>
</html>
