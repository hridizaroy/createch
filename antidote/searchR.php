<?php

    require 'db.php';
    session_start();

    //Checking if logged in
    if ( isset($_SESSION['logged_in']) ) {
        if($_SESSION['logged_in'] != true){
            $_SESSION['message'] = "Sorry. You're not logged in.";
            header("location: error.php");
        }
    }
    else {
        $_SESSION['message'] = "Sorry. You're not logged in.";
        header("location: error.php");
    }


    //User details
    $email = $_SESSION['email'];

    $lat = $_POST['lat'];
    $long = $_POST['long'];

    $radius = $_POST['radius'];

    //Coordinates in radians
    $lat_rad = $lat*pi()/180;
    $long_rad = $long*pi()/180;

    $police = $_SESSION['police'];

    $q = $_POST['q'];

    /*
    Haversine formula (to calculate distance between 2 points given their latitude and longitude):
    a = sin²(Δφ/2) + cos φ1 ⋅ cos φ2 ⋅ sin²(Δλ/2)
    c = 2 ⋅ atan2( √a, √(1−a) )
    d = R ⋅ c
    where	φ is latitude, λ is longitude, R is earth’s radius;
    note that angles need to be in radians to pass to trig functions
    */

    function dist($latitude, $longitude) {
        global $lat_rad, $long_rad;

        $latitude = $latitude*pi()/180;
        $longitude = $longitude*pi()/180;

        $R = 6.371*pow(10, 6); //Radius of Earth in metres
        $a = sin( ($latitude - $lat_rad)/2 )*sin( ($latitude - $lat_rad)/2 ) + cos($lat_rad)*cos($latitude)*sin( ($longitude - $long_rad)/2 )*sin( ($longitude - $long_rad)/2 );
        $c = 2*atan2( sqrt($a), sqrt(1-$a) ); //Returns angle from x and y coordinate values
        $d = $R*$c; //Distance between the 2 points

        return $d;
    }

    //Getting users within radius
    if ($police) {
        $setLocation = $mysqli->query("UPDATE police SET latitude = $lat, longitude = $long WHERE email = '$email'");
        $getUsers = $mysqli->query("SELECT * FROM civilians WHERE active = 1");
    }
    else {
        $setLocation = $mysqli->query("UPDATE civilians SET latitude = $lat, longitude = $long WHERE email = '$email'");
        $getUsers = $mysqli->query("SELECT * FROM police WHERE active = 1 and verified = 1");
    }

    $users = array();

    if ($getUsers != false) {

        while($row = $getUsers->fetch_assoc()){
            if (dist($row['latitude'], $row['longitude']) <= $radius) {
                $user = $row['email'];
                array_push($users, "'$user'");
            }
        }

        $arr = '('.implode(",", $users).')';

        $today = date("Y-m-d");

        if ($police) {
            $prods = $mysqli->query("SELECT * FROM prods WHERE email in $arr AND expiry >= '$today' AND (descript LIKE '%$q%' OR title LIKE '%$q%')");
        }
        else {
            $prods = $mysqli->query("SELECT * FROM reqs WHERE email in $arr AND expiry >= '$today' AND (descript LIKE '%$q%' OR title LIKE '%$q%')");
        }

        if ($prods) {
            while ($row = $prods->fetch_assoc()) {
                if ($row['pType'] == 1) {
                    $type = "Product";
                }
                else {
                    $type = "Service";
                }
                echo "<div class = 'prod card'>";
                echo "<div class='card-body'>";
                if ($row['pType'] == 1) {
                    echo "<img class='card-image' src='images/services-icon-3.svg' alt='alternative'>";
                }
                else {
                    echo "<img class='card-image' src='images/services-icon-1.svg' alt='alternative'>";
                }
                echo "<h4>".$row['title']."</h4>";
                echo "<p>Description: ".$row['descript']."</p>";
                echo "<p>Type: ".$type."</p>";
                echo "<p>Expires on: ".$row['expiry']."</p>";
                echo "<p class = 'user'>".$row['email']."</p>";
                echo "</div></div><br>";
            }
        }
    }
    else {
        echo "<p>No results for the search</p>";
    }

?>
