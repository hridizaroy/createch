<?php

    function listTeams($mysqli, $username) {

        $teamsList = $mysqli->query("SELECT teams FROM users WHERE username = '$username'");

        $teamsList = $teamsList->fetch_assoc();
        $teamsList = unserialize($teamsList['teams']);

        $teamNames = array();

        if ($teamsList) {
            foreach ($teamsList as $team) {
                $team = explode(";", $team)[0];
                array_push($teamNames, $team);
            }
        }

        return array($teamsList, $teamNames);
    }

    function listProjects($team) {

        $fileDir = "./$team/";
        $projectsList = array();

        if($handle = opendir($fileDir)) {
            while ($entry = readdir($handle)) {
                if ( $entry != "."  && $entry != ".." ){
                    array_push($projectsList, $entry);
                }
            }
            closedir($handle);
        }

        return $projectsList;
    }

    function listFiles($team, $project) {
        
        $fileDir = "./$team/$project/files/";

        $filesList = array();

        if($handle = opendir($fileDir)) {
            while ($entry = readdir($handle)) {
                if ( $entry != "."  && $entry != ".." ){
                    array_push($filesList, $entry);
                }
            }
            closedir($handle);
        }

        return $filesList;
    }

    function addToGameFile($username, $teamName, $projectName, $game) {
        
        $gameFile = $teamName."/$projectName/$game";
        $existingNames = array();

        if (file_exists($gameFile)) {
            if (filesize($gameFile) > 0) {
                $gameOpen = fopen($gameFile, "r");
                $activeNow = fread($gameOpen, filesize($gameFile));
                $existingNames = preg_split('/[\s]+/', $activeNow);
                fclose($gameOpen);
            }
        }

        $gameOpen = fopen($gameFile, "a");
        if (!in_array($username, $existingNames)) {
            fwrite($gameOpen, $username."\n");
            fclose($gameOpen);
        }
    }

    function removeFromGameFile($username, $teamName, $projectName, $game) {
        $activeNowFile = $teamName."/$projectName/$game";
        $existingNames = array();

        if (filesize($activeNowFile) > 0) {
            $activeNowOpen = fopen($activeNowFile, "r");
            $activeNow = fread($activeNowOpen, filesize($activeNowFile));
            $existingNames = preg_split('/[\s]+/', $activeNow);
            fclose($activeNowOpen);
        }
        if (count($existingNames) > 0) {
            $activeNowOpen = fopen($activeNowFile, "w");
            for ($i = 0; $i < count($existingNames); $i++) {
                if ($existingNames[$i] != $username) {
                    fwrite($activeNowOpen, $existingNames[$i]."\n");
                }
            }
            fclose($activeNowOpen);
        }
    }

?>