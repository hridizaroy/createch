<?php

require 'db.php';

session_start();

$username = $_POST['username'];
$teamName = $_POST['teamName'];
$projectName = $_POST['projectName'];

$sql = $mysqli->query("SELECT status FROM activeStatus WHERE username = '$username'");

$status = $sql->fetch_assoc();
$status = $status['status'];

echo $status;

header('Access-Control-Allow-Origin: *');


?>