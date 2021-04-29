<?php

    require 'db.php';
    session_start();

    require 'functions.php';

    $projects = listProjects($_SESSION['teamName']);

    if (isset($_POST['projectName'])) {
        if (in_array($_POST['projectName'], $projects)) {
            echo "0";
        }
        else {
            echo "1";
        }
    }

?>