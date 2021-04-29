<?php

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$to = "createchrisvk@gmail.com";
$subject = "Query for .createch 2.0";

$msg = "From: $name\nEmail: $email\n$message";

mail($to, $subject, $msg);

header("location: home.html");