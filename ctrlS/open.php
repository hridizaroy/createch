<?php

       $file_name = $_POST['openFileName'];
       $teamName = $_POST['teamName'];
       $projectName = $_POST['projectName'];

       $fileDir = $teamName."/$projectName/files/";


       $file = fopen($fileDir.$file_name, "r");
       $fileContent = fread($file, filesize($fileDir.$file_name));
       fclose($file);

       echo $fileContent;

?>