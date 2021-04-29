<?php

    $teamName = $_POST['teamName'];

    $projectName = $_POST['fileName'];

    $fileDir = "./$teamName/$projectName/chats/";

    $chat = "";

    if($handle = opendir($fileDir)) {
        global $chat;
        while ($entry = readdir($handle)) {
            if ( $entry != "."  && $entry != ".." ){
                $chat = $entry;
            }
        }
        closedir($handle);
    }

    if ($chat !== "") {
        $file = fopen($fileDir.$chat, "r");

        $allChats = fread($file, filesize($fileDir.$chat));

        fclose($file);

        echo $allChats;
    }

?>