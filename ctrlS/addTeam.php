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


    //Adding team
    $username = $_SESSION['username'];

    if(isset($_POST['addTeam'])) {
        //Getting teamslist of admin
        $teamsList = $mysqli->query("SELECT teams FROM users WHERE username = '$username'");
        $teamsList = $teamsList->fetch_assoc();
        $teamsList = unserialize($teamsList['teams']);

        //If team name already exists, throw error
        if (in_array($_POST['newTeam'], $teamsList)) {
            $_SESSION['message'] = "Sorry. You're already a part of a team with that name";
            header("location: error.php");
        }
        else {
            //Team name = "name;adminName"
            $tName = $_POST['newTeam'].";".$username;

            //Add team name to teams list
            array_push($teamsList, $tName);
            $teamsList_ser = serialize($teamsList);

            $sql = "UPDATE users SET teams =" . "'$teamsList_ser'" . " WHERE username = " . "'$username'";

            //If sql fails
            if ( !($mysqli->query($sql)) ){
                $_SESSION['message'] = 'Add team failed';
                header("location: error.php");
            }
            //Adding members' usernames to teams table
            else {
                $memsList = array();
                for ($i = 1; $i <= $_POST['noOfMems']; $i++) {
                    array_push($memsList, $_POST['mem'.$i]);
                }
                $memsList_ser= serialize($memsList);

                $sql = "INSERT INTO teams (teamName, members)". "VALUES ('$tName', '$memsList_ser')";

                //Error on sql failure
                if ( !($mysqli->query($sql)) ){
                    $_SESSION['message'] = 'Add team failed';
                    header("location: error.php");
                }
                //If successful, make a folder with team name and redirect to main page
                else {
                    for ($i = 0; $i < count($memsList); $i++) {
                        $user = $memsList[$i];
                        $teams = $mysqli->query("SELECT teams FROM users WHERE username ='$user'");
                        $teams = $teams->fetch_assoc();
                        $teams = unserialize($teams['teams']);

                        //Add team name to teams list
                        array_push($teams, $tName);
                        $teams = serialize($teams);

                        $sql = "UPDATE users SET teams =" . "'$teams'" . " WHERE username = "."'$user'";

                        //Error on sql failure
                        if ( !($mysqli->query($sql)) ){
                            $_SESSION['message'] = 'Add team failed';
                            header("location: error.php");
                        }
                    }
                    if (mkdir("{$tName}")) {
                        header("location: teams.php");
                    }
                    else {
                        $_SESSION['message'] = 'Adding team failed. Consider changing the name.';
                        header("location: error.php");
                    }
                }
            }
        }
    }

?>

<html>

<head>
<title>Add Team Ctrl+S</title>
    <!-- Add to homescreen for Chrome on Android -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="icon" sizes="192x192" href="images/android-desktop.png">

  <!-- Add to homescreen for Safari on iOS -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="The Dreamweavers Charitable Trust">
  <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

  <!-- Tile icon for Win8 (144x144 + tile color) -->
  <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
  <meta name="msapplication-TileColor" content="#3372DF">

  <link rel="shortcut icon" href="images/favicon.png">

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-indigo.min.css" />

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }

        label, input {
            display: block;
        }
        input[type=text] {
          font-family: 'lato', helvetica;
          font-size: 1.3em;
          line-height: 1.5;
        }

        .errMsg {
            display: none;
        }
        form, .errMsg, .check, p{
          margin: 2%;
        }
        .next {
          margin: 2% 0;
          width: 5%;
        }
        .submit {
            margin: 2% 0;
        }
   </style>
</head>

<body>

    <form method = "post">

        <div class = "namingTheTeam">

            <label for = "newTeam">Team Name</label>
            <input type = "text" name = "newTeam" required class = "teamName">

            <input type = "hidden" value = "<?php echo $username ?>" class = "admin">

            <span class = "next mdl-button mdl-js-button mdl-button--raised mdl-color--primary">Next</span>
        </div>

        <div class = "members">
            <label for = "noOfMems">No. of members</label>
            <input type = "number" min = "1" max = "10" value = "1" name = "noOfMems" class = "noOfMems" required>

            <div class = "mems">

                <div class = "member">
                    <label for = "mem1">Member 1 username</label>
                    <input type = "text" name = "mem1">
                    <p class = "check"></p>
                </div>

            </div>
            <input type = "submit" name = "addTeam" value = "Add Team" class = "submit mdl-button mdl-js-button mdl-button--raised mdl-color--primary">
        </div>
    </form>

    <p class = "errMsg">Min Members: 1, Max members: 10 (excluding admin)</p>
    <p class = "errMsg checkName">Sorry, team name cannot contain ';'</p>
    <p class = "errMsg checkAdmin">You need not add yourself as a member</p>
    <p class = "errMsg checkTeam">Team name already exists</p>
    <p class = "errMsg checkMems">Can't add the same member twice</p>

    <p><a href = "home.php">Home</a></p>
    <p><a href = "logout.php">Log out</a></p>


    <script>

        document.querySelector('.members').style.display = "none";

        document.querySelector(".noOfMems").addEventListener('input', nameFields);

        document.querySelector(".teamName").addEventListener('input', checkName);
        inputCheck();

        function inputCheck() {
            var mems = document.querySelectorAll(".mems input");
            for (var i = 0; i < mems.length; i++) {
                mems[i].addEventListener('input', check);
            }
        }

        function nameFields() {
            if (this.value >= 1 && this.value <= 10) {
                document.querySelector('.errMsg').style.display = "none";
                document.querySelector('.mems').innerHTML = "";
                document.querySelector('.submit').disabled = false;

                for (var i = 1; i <= this.value; i++) {
                    var cont = document.createElement('div');
                    cont.className = "member";

                    var mem = document.createElement('input');
                    mem.type = "text";
                    mem.name = "mem" + String(i);
                    mem.required = true;

                    var label = document.createElement('label');
                    label.for = "mem" + String(i);
                    label.innerHTML = "Member " + String(i) + " username";

                    var err = document.createElement('p');
                    err.className = "check";

                    cont.appendChild(label);
                    cont.appendChild(mem);
                    cont.appendChild(err);

                    document.querySelector('.mems').appendChild(cont);

                    inputCheck();
                }
            }
            else {
                document.querySelector('.mems').innerHTML = "";
                document.querySelector('.errMsg').style.display = "block";
                document.querySelector('.submit').disabled = true;
            }

        }

        function checkName() {
            if (this.value.includes(";")) {
                document.querySelector('.checkName').style.display = "block";
                document.querySelector('.submit').disabled = true;
                document.querySelector(".next").style.display = "none";
            }
            else {
                check(this, document.querySelector('.admin'));
                document.querySelector('.checkName').style.display = "none";
            }
        }


        function check(a, b) {
            b = b || 0;
            if (b === 0) {
                a = this;
            }
            else {
                a = b;
            }

            if (a.value == '<?php echo $username ?>' && b.value != '<?php echo $username ?>') {
                document.querySelector('.submit').disabled = true;
                a.parentNode.childNodes[2].innerHTML = "";
                document.querySelector('.checkAdmin').style.display = "block";
            }
            else {
                const params = "username=" + a.value + "&teamName=" + document.querySelector('.teamName').value;

                var xhttp = new XMLHttpRequest();
                var url = "checkTeamName.php";
                xhttp.open("POST", url, true);

                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if (xhttp.responseText != "") {
                            a.parentNode.childNodes[2].innerHTML = xhttp.responseText;
                            document.querySelector('.submit').disabled = true;
                            document.querySelector(".next").style.display = "none";
                        }
                        else {
                            a.parentNode.childNodes[2].innerHTML = "";
                            document.querySelector('.submit').disabled = false;
                            document.querySelector(".next").style.display = "block";
                        }
                        var block = document.getElementsByClassName('check');
                        for ( var x = 0; x < block; x++) {
                            if (block[x].innerHTML != "") {
                                document.querySelector('.submit').disabled = true;
                                break;
                            }
                        }
                        if (document.querySelector('.checkMems').style.display == "block") {
                            document.querySelector('.submit').disabled = true;
                        }
                    }
                };
                xhttp.send(params);
            }

            var mems = document.querySelectorAll(".mems input");
            document.querySelector('.checkAdmin').style.display = "none";
            var values = Array();
            for (var i = 0; i < mems.length; i++) {
                if (mems[i].value == '<?php echo $username ?>') {
                    document.querySelector('.checkAdmin').style.display = "block";
                    break;
                }
            }
            document.querySelector('.checkMems').style.display = "none";
            for (var i = 0; i < mems.length; i++) {
                if ( values.includes(mems[i].value) && mems[i].value != "" ) {
                    document.querySelector('.checkMems').style.display = "block";
                    break;
                }
                values.push(mems[i].value);
            }
        }

        document.querySelector(".next").addEventListener('click', next);

        function next() {
            if (document.querySelector(".teamName").value != "") {
                document.querySelector('.namingTheTeam').style.display = "none";
                document.querySelector('.members').style.display = "block";
            }
            else {
                document.querySelector('.checkTeam').innerHTML = "Team name cannot be empty";
            }
        }

    </script>

</body>


</html>

