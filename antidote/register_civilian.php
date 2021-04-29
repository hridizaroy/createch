<?php

$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
$DOB = $mysqli->escape_string($_POST['DOB']);
$aadhar = $mysqli->escape_string($_POST['aadhar']);

//Checking if email already exists
$result_civilians = $mysqli->query("SELECT * FROM civilians WHERE email = '$email'") or die($mysqli->error());
$result_police = $mysqli->query("SELECT * FROM police WHERE email = '$email'") or die($mysqli->error());

if ($result_civilians->num_rows > 0 or $result_police->num_rows > 0) {
    $_SESSION['message'] = "User with that email already exists.";
    header("location: error.php");
}

else {

    $sql = "INSERT INTO civilians (email, password, hash, first_name, last_name, DOB, aadhar_no)" . "VALUES ('$email', '$password', '$hash', '$first_name', '$last_name', '$DOB', '$aadhar')";
    $sql2 = "INSERT INTO activestatus (email) VALUES ('$email')";

    if ( $mysqli->query($sql) and $mysqli->query($sql2) ){
        $_SESSION['active'] = 0;
        $_SESSION['police'] = false;

        $_SESSION['logged_in'] = true;
        
        $_SESSION['message'] = 
                    "Confirmation link has been sent to $email, please verify your account by clicking on the link in the message.\n
                    If you don't find the email in your inbox, please check your spam folder. smh.";
    
        $to = $email;
        $subject = 'Account Verification (Anti-dote)';
        $message_body = '
        Hello '.$first_name.',
        Thank You for signing up!
        Please click this link to activate your account:

        https://www.createchrisvk.in/antidote/verify.php?email='.$email.'&hash='.$hash.'&police=0';

        mail( $to, $subject, $message_body );

        if (mkdir("$email", 0755, true)) {
            if (mkdir("$email/chats", 0755, true)) {
                header("location: success.php"); 
            }
        }
    }

    else {
        $_SESSION['message'] = 'Registration Failed.';
        header("location: error.php");
    }
}

?>
