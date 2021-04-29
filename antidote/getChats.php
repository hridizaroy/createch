<?php

    $username = $_POST['user'];
    $to = $_POST['to'];

    $fileDir = "./$username/chats/";

    $chat = $to.".txt";

    $file = fopen($fileDir.$chat, "r");

    $allChats = fread($file, filesize($fileDir.$chat));

    fclose($file);

    echo $allChats;

?>
