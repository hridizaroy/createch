<?php

    $teamName = trim(trim(trim($_POST['teamName'], '"')), "'");
    $projectName = trim(trim(trim($_POST['projectName'], '"')), "'");

    $fileDir = $teamName."/$projectName/files/";
    $fileName = "synced.txt";

    $fileCont = "\n".urldecode($_POST['fileCont'])."\n";

    $file = fopen($fileDir.$fileName, "a");
    
    fwrite($file, $fileCont);

    fclose($file);

    header('Access-Control-Allow-Origin: *');

?>