<?php

    require 'db.php';

    $user = "User: ".$_POST['user']."\n";

    $msg_raw = $_POST['chatContent'];

    $msg = "Msg: ".$_POST['chatContent']."\n";
    $timeOfMsg = "Time: ".$_POST['time']."\n";

    $dateOfMsg = "Date: ".$_POST['fullDate']."\n";

    $username = $_POST['police'];

    $fileDir = "./$username/chats/";

    $chat = "public.txt";

    $file = fopen($fileDir.$chat, "a");

    fwrite($file, $msg.$user.$timeOfMsg.$dateOfMsg);

    fclose($file);

?>
