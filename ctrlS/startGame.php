<?php

    require 'db.php';
    session_start();
    require 'functions.php';

    $game = "word.txt";
    $gameData = "wordData.txt";

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

    if (isset($_POST['startGame'])) {
        startGame();
    }

    if (isset($_POST['gameOver'])) {

        $username = "User: ".$_POST['username']."\n";
        $teamName = $_POST['teamName'];
        $projectName = $_POST['projectName'];
        $prompt = "Prompt: ".$_POST['prompt']."\n";
        $ans = "Ans: ".$_POST['ans']."\n";

        $file = $teamName."/$projectName/$gameData";

        $fileOpen = fopen($file, "w");
        fwrite($fileOpen, $username.$prompt.$ans);
        fclose($fileOpen);

        if ($_POST['gameOver'] == '1') {
            removeFromGameFile($_POST['username'], $_POST['teamName'], $projectName, $game);
            $fileOpen = fopen($file, "w");
            fclose($fileOpen);
        }    
    }

    if (isset($_POST['getData'])) {
        $file = $teamName."/$projectName/$gameData";
        $game = fopen($file, "r");

        $open = fread($game, fileSize($file));

        echo $open;
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
        }
        else {
            echo $name;
        }
    }

    if (isset($_POST['turn'])) {
        turn();
    }

?>