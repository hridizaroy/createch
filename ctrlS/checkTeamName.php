<?php

require 'db.php';
session_start();

$username = $mysqli->escape_string($_POST['username']);
$teamName = $mysqli->escape_string($_POST['teamName']);

$teamsList = $mysqli->query("SELECT teams FROM users WHERE username = '$username'");

if ($teamsList->num_rows == 0) {
    echo "User with that username doesn't exist";
}
else {
    $teamsList = $teamsList->fetch_assoc();
    $teamsList = unserialize($teamsList['teams']);

    if ($teamsList) {

        $teamNames = array();

        foreach ($teamsList as $team) {
            $team = explode(";", $team)[0];
            array_push($teamNames, $team);
        }

        if (in_array($teamName, $teamNames)) {
            if ($username == $_SESSION['username']) {
                echo "You are already part of a team with that name";
            }
            else {
                echo "User is already part of a team with that name";
            }
        }

    }
}

?>
