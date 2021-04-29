<?php

    require 'db.php';

    $to = $_POST['to'];
    $points = $_POST['points'];

    $sql = "UPDATE civilians SET points = points + $points WHERE email = '$to'";

    if ($mysqli->query($sql)) {
      echo "Points added successfully!";
    }
    else {
      echo "Failed to add points.";
    }


 ?>
