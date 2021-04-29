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
    
    require 'functions.php';

    $username = $_SESSION['username'];
?>

<html>
<head>
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
<link rel="stylesheet" href="styles.css">
<style>
    .projects {
        display: none;
        margin: 1% 0;
    }

    .addTeam a {
        color: #fff;
        text-decoration: none;
    }

    .teams {
        margin: 3%;
    }

    .team {
        margin: 2% 0;
        font-size: 1.2em;
    }
    ul {
        position: relative;
        list-style: none;
    }

    li::before {
        content: '▶';
        position: absolute;
        left: 0;
    }

    .addProject {
        color: #fff;
        margin: 1% 0;
    }

    li {
        cursor: pointer;
    }

    .projects li, .projects p {
        font-size: 1.2em;
    }

    form, .errMsg, .check, p{
        margin: 2%;
    }
</style>
</head>
    <body>

    <div class = "teams">

        <h3>My Teams</h3>
        <ul>

        <?php
            $teamsList = listTeams($mysqli, $username)[0];
            $teamNames = listTeams($mysqli, $username)[1];
            for ($i = 0; $i < count($teamNames); $i++) {
                echo "<div class = 'team'>";
                echo("<li>".$teamNames[$i]."</li>");

                $team = $teamsList[$i];

                $projectsList = listProjects($team);
                echo "<ul class = 'projects'>";
                for ($x = 0; $x < count($projectsList); $x++) {
                    echo("<li class = '$team'>".$projectsList[$x]."</li>");
                }
                if (count($projectsList) == 0) {
                    echo "<p>No projects by this team</p>";
                }

                echo "<button class = 'addProject mdl-button mdl-js-button mdl-button--raised mdl-color--primary' id = '$team'>Add Project</button>";
                echo "</ul>";
                echo "</div>";
            }
        ?>
        </ul>
        <button class = "addTeam  mdl-button mdl-js-button mdl-button--raised mdl-color--red"><a href = "addTeam.php">Add Team</a></button>
        
    </div>

    <p><a href = "home.php">Home</a></p>
    <p><a href = "logout.php">Log out</a></p>


    <script>

        var teams = document.querySelectorAll('.teams .team');

        var projects = document.getElementsByClassName('projects');

        var allProjects = document.querySelectorAll('.projects li');

        var addProjButtons = document.querySelectorAll('.addProject');

        for (var i = 0; i < teams.length; i++) {
            teams[i].addEventListener('click', showProj);
        }

        for (var i = 0; i < addProjButtons.length; i++) {
            addProjButtons[i].addEventListener('click', setTeam);
        }

        for (var i = 0; i < allProjects.length; i++) {
            allProjects[i].addEventListener('click', openProject);
        }


        function showProj() {
            for (var x = 0; x < projects.length; x++) {
                projects[x].style.display = "none";
            }
            this.childNodes[1].style.display = "block";
        }


        function setTeam() {
            const params = "teamName=" + this.id;

            var xhttp = new XMLHttpRequest();
            var url = "addProject.php";
            xhttp.open("POST", url, true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.href = url;
                }
            };
            xhttp.send(params);
        }


        function openProject() {
            const params = "teamName=" + this.className + "&projectName=" + this.innerText;

            var xhttp = new XMLHttpRequest();
            var url = "newfile.php";
            xhttp.open("POST", url, true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.href = url;
                }
            };
            xhttp.send(params);
        }


    </script>

    </body>

</html>
