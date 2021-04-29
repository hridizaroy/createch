<?php

    require 'db.php';
    session_start();
    require 'functions.php';

    $game = "draw.txt";
    $gameData = "drawData.txt";

    $teamName = $_SESSION['teamName'];
    $projectName = $_SESSION['projectName'];

    function startGame() {

        global $game, $gameData, $mysqli, $teamName, $projectName;

        $sql = $mysqli->query("SELECT username FROM activeStatus WHERE status = '1' AND project = '$projectName' AND team = '$teamName'");
        
        $active = array();
        while ($row = mysqli_fetch_array($sql, MYSQLI_NUM)) {
            array_push($active, $row[0]);
        }
        
        $gameFile = $teamName."/$projectName/$game";        
        $gameOpen = fopen($gameFile, "w");
        fclose($gameOpen);

        foreach ($active as $username) {
            addToGameFile($username, $teamName, $projectName, $game);
        }

    }

    function gameOver() {
        global $game, $gameData, $mysqli, $teamName, $projectName;

        $file = $teamName."/$projectName/$gameData";
        removeFromGameFile($_POST['username'], $_POST['teamName'], $projectName, $game);
        $fileOpen = fopen($file, "w");
        fclose($fileOpen);

    }

    if (isset($_POST['startGame'])) {
        startGame();
    }

    if (isset($_POST['gameOver'])) {
        if ($_POST['gameOver'] == '1') {
            gameOver();
        }    
    }

    function turn() {
        global $game, $gameData, $mysqli, $teamName, $projectName;

        $file = $teamName."/$projectName/$game";

        $file = fopen($file,"r");
        $name = fgets($file);
        fclose($file);

        if ($name == "") {
            $gameFile = $teamName."/$projectName/$game";        
            $gameOpen = fopen($gameFile, "w");
            fclose($gameOpen);

            $gameFile = $teamName."/$projectName/$gameData";        
            $gameOpen = fopen($gameFile, "w");
            fclose($gameOpen);

            echo "";
        }
        else {
            echo $name;
        }
    }

    if (isset($_POST['turn'])) {
        turn();
    }

    if (isset($_POST['guess'])) {
        $gameFile = $teamName."/$projectName/$gameData";        
        $gameOpen = fopen($gameFile, "r");
        $word = fgets($gameOpen);
        if (strtolower(trim($word)) == strtolower(trim($_POST['guess']))) {
            gameOver();
            echo '1';
        }
        else {
            echo '0';
        }
        fclose($gameOpen);
    }


?>