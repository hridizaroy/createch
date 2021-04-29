<?php

    session_start();

    //Session variables
    $team = $_SESSION['teamName'];
    $project = $_SESSION['projectName'];

    $pic = $_POST['pic'];
    $word = $_POST['word'];
    $img = str_replace('data:image/png;base64,', '', $pic);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);


   //Enter file data to store image in
    $fileDir = "./$team/$project/";
    $file_to_open = "image.png";

    $file = $fileDir.$file_to_open;
    $success = file_put_contents($file, $data);

    $file = $team."/$project/drawData.txt";

    $fileOpen = fopen($file, "w");
    fwrite($fileOpen, $_POST['word']);
    fclose($fileOpen);

?>