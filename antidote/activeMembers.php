<?php

require 'db.php';

session_start();

$email = $_SESSION['email'];

$lat = $_POST['lat'];
$long = $_POST['long'];

$tm = date("Y-m-d H:i:s");
$sql = $mysqli->query("UPDATE activestatus SET astatus= '1', tm = '$tm' where email = '$email'");

$gap = 120; //Gap in seconds
$tLeft = date("Y-m-d H:i:s", mktime (date("H"),date("i"),date("s")-$gap,date("m"),date("d"),date("Y")));

$ut = $mysqli->query("UPDATE activestatus SET astatus = '0' where tm < '$tLeft'");

?>
