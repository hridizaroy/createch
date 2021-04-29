<?php

    require 'db.php';

    $user = "User: ".$_POST['user']."\n";

    $msg_raw = $_POST['chatContent'];

    $msg = "Msg: ".$_POST['chatContent']."\n";
    $timeOfMsg = "Time: ".$_POST['time']."\n";

    $dateOfMsg = "Date: ".$_POST['fullDate']."\n";

    $username = $_POST['user'];
    $to = $_POST['to'];

    $fileDir1 = "./$username/chats/";
    $fileDir2 = "./$to/chats/";

    $chat1 = $to.".txt";
    $chat2 = $username.".txt";

    $file1 = fopen($fileDir1.$chat1, "a");
    $file2 = fopen($fileDir2.$chat2, "a");

    fwrite($file1, $msg.$user.$timeOfMsg.$dateOfMsg);
    fwrite($file2, $msg.$user.$timeOfMsg.$dateOfMsg);

    fclose($file1);
    fclose($file2);

    //Notify if offline
    $status = $mysqli->query("SELECT astatus from activestatus WHERE email = '$to'");
    $row = $status->fetch_assoc();

    if ($row['astatus'] == 0) {
        $subject = "New message on (Anti-dote)";
        $message_body = "$username sent you a message on (Anti-dote)!
        $username: $msg_raw";
        mail($to, $subject, $message_body);
    }

?>
