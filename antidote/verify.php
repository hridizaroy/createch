<?php

require 'db.php';
session_start();

if(isset($_GET['email']) AND isset($_GET['hash']) AND isset($_GET['police']) && !empty($_GET['hash']))
{
    $email = $mysqli->escape_string($_GET['email']);
    $hash = $mysqli->escape_string($_GET['hash']);

    if ($_GET['police'] == 1) {
        $result = $mysqli->query("SELECT * FROM police WHERE email = '$email' AND hash = '$hash' AND active = '0'");
    }
    else if ($_GET['police'] == 0) {
        $result = $mysqli->query("SELECT * FROM civilians WHERE email = '$email' AND hash = '$hash' AND active = '0'");
    }
    else {
        $_SESSION['message'] = "Invalid URL";
        header("location: error.php");       
    }

    if( $result->num_rows == 0){
        $_SESSION['message'] = "Account has already been activated or the URL is invalid";
        header("location: error.php");
    }
    else {
        $_SESSION['message'] = "Your account has been activated.";
        
        if ($_GET['police'] == 1) {
            $mysqli->query("UPDATE police SET active = '1' WHERE email = '$email'") or die($mysqli->error);
        }
        else if ($_GET['police'] == 0) {
            $mysqli->query("UPDATE civilians SET active = '1' WHERE email = '$email'") or die($mysqli->error);
        }        

        header("location: logout.php");
    }
}

else {
    $_SESSION['message'] = "Invalid Parameters provided for account verification";
    header("location: error.php");
}

?>