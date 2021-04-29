<?php

    $username = $_POST['police'];

    $fileDir = "./$username/chats/";


    $chat = "public.txt";

    $file = fopen($fileDir.$chat, "r");

    $allChats = fread($file, filesize($fileDir.$chat));

    fclose($file);

    echo $allChats;

?>
