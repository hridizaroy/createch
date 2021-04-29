<?php

    $threadName = $_POST['threadName'];

    $fileDir = "chats/";

    $chat = "$threadName.txt";

    $file = fopen($fileDir.$chat, "r");

    $allChats = "";

    if (filesize($fileDir.$chat) > 0) {
        $allChats = fread($file, filesize($fileDir.$chat));
    }

    fclose($file);

    echo $allChats;

?>