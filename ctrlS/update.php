<?php

    $file_to_open = $_POST['openFileName'];

    $fileOpenContent = $_POST['openedFile'];

    $teamName = $_POST['teamName'];
    $projectName = $_POST['projectName'];

    $fileDir = $teamName."/$projectName/files/";

    $openFile = fopen($fileDir.$file_to_open, "w");

    fwrite($openFile, $fileOpenContent);
    fclose($openFile);

?>