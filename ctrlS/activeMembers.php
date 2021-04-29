<?php

require 'db.php';

session_start();

$username = $_POST['username'];
$teamName = $_POST['teamName'];
$projectName = $_POST['projectName'];

$tm = date("Y-m-d H:i:s");
$sql = $mysqli->query("UPDATE activeStatus SET status = '1', tm = '$tm', project = '$projectName', team = '$teamName' where username = '$username'");

$gap = 2; //Gap in seconds
$tLeft = date("Y-m-d H:i:s", mktime (date("H"),date("i"),date("s")-$gap,date("m"),date("d"),date("Y")));

$ut = $mysqli->query("UPDATE activeStatus SET status = '0' where tm < '$tLeft'");

$sql2 = $mysqli->query("SELECT username FROM activeStatus WHERE status = '1' AND project = '$projectName' AND team = '$teamName'");

$row = mysqli_fetch_array($sql2, MYSQLI_NUM);
$active = $row[0];
while ($row = mysqli_fetch_array($sql2, MYSQLI_NUM)) {
    $active.=", ".$row[0];
}

echo $active;


?>