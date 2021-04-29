<?php

    session_start();

    //Session variables
    $team = $_SESSION['teamName'];
    $project = $_SESSION['projectName'];


   //Enter file data to store image in
    $fileDir = "./$team/$project/";
    $file_name = "image.png";

    if (file_exists($fileDir.$file_name)) {
        $file = fopen($fileDir.$file_name, "r");
        $fileContent = base64_encode(fread($file, filesize($fileDir.$file_name)));

        echo $fileContent;
    }

?>