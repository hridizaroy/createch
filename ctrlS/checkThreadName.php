<?php

    require 'db.php';
    session_start();

    $files = listThreads();

    if (isset($_POST['thread'])) {
        if (in_array($_POST['thread'].".txt", $files)) {
            echo "0";
        }
        else {
            echo "1";
        }
    }

    function listThreads() {
        
        $fileDir = "chats/";

        $filesList = array();

        if($handle = opendir($fileDir)) {
            while ($entry = readdir($handle)) {
                if ( $entry != "."  && $entry != ".." ){
                    array_push($filesList, $entry);
                }
            }
            closedir($handle);
        }

        return $filesList;
    }

?>