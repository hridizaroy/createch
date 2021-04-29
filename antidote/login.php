<?php

$email = $mysqli->escape_string($_POST['email']);
$result_police = $mysqli->query("SELECT * FROM police WHERE email = '$email'");
$police = true;

if ( $result_police->num_rows == 0){
    $result_civilians = $mysqli->query("SELECT * FROM civilians WHERE email = '$email'");
    $police = false;
    if ( $result_civilians->num_rows == 0){
        $_SESSION['message'] = "User with that email doesn't exist";
        header("location: error.php");
    }
}

if ($police) {
    $user = $result_police->fetch_assoc();
}
else {
    $user = $result_civilians->fetch_assoc();
}


if ( password_verify($_POST['password'], $user['password']) ) {

    $_SESSION['email'] = $user['email'];
    $_SESSION['first-name'] = $user['first_name'];
    $_SESSION['last-name'] = $user['last_name'];
    $_SESSION['active'] = $user['active'];
    $_SESSION['police'] = $police;

    if ($police) {
      $_SESSION['verified'] = $user['verified'];
    }

    $_SESSION['logged_in'] = true;

    header("location: landing_page.php");

}

else {
    $_SESSION['message'] = "Wrong Password. Try again.";
    header("location: error.php");
}

?>
