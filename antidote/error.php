<?php
    session_start();
    $home = "landing_page.php";
?>

<html>
    <head>
        <title>Error</title>

      <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-indigo.min.css" />
      <link rel="stylesheet" href="styles.css">
      <link rel="icon" href="images/logo round.png">
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
                    header( "location: $home");
                endif;
                ?>
                </p>
                <a href = "<?php echo $home ?>" class = "home"><button class = "button button-block mdl-button mdl-js-button mdl-button--raised mdl-color--primary">Home</button></a>
        </div>
    </body>
</html>
