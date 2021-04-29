<?php

require 'db.php';
session_start();

$username = $_SESSION['username'];

$sql = $mysqli->query("UPDATE activeStatus set status='0' where username='$username'");
$gap = 2; //Gap in seconds
$tLeft = date("Y-m-d H:i:s", mktime (date("H"),date("i"),date("s")-$gap,date("m"),date("d"),date("Y")));

$ut = $mysqli->query("UPDATE activeStatus SET status = '0' where tm < '$tLeft'");


$_SESSION['logged_in'] = false;

session_destroy();

header("location: home.php");