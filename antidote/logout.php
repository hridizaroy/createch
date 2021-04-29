<?php

require 'db.php';
session_start();

if (isset($_SESSION['logged_in'])) {
    $email = $_SESSION['email'];
    
    $sql = $mysqli->query("UPDATE activeStatus set astatus='0' where email='$email'");
    $gap = 120; //Gap in seconds
    $tLeft = date("Y-m-d H:i:s", mktime (date("H"),date("i"),date("s")-$gap,date("m"),date("d"),date("Y")));
    
    $ut = $mysqli->query("UPDATE activeStatus SET astatus = '0' where tm < '$tLeft'");
    
    
    $_SESSION['logged_in'] = false;    
}

session_destroy();

header("location: landing_page.php");
