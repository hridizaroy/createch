<?php

    $user = "User: ".$_POST['user']."\n";

    $msg = "Msg: ".$_POST['chatContent']."\n";
    $timeOfMsg = "Time: ".$_POST['time']."\n";

    $dateOfMsg = "Date: ".$_POST['fullDate']."\n";

    $teamName = $_POST['teamName'];

    $projectName = $_POST['fileName'];

    $fileDir = "./$teamName/$projectName/chats/";

    $chat = "chat1.txt";

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
        $file = fopen($fileDir.$chat, "a");

        fwrite($file, $msg.$user.$timeOfMsg.$dateOfMsg);

        fclose($file);

    }

?>
