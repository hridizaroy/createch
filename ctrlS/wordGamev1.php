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

$username = $_SESSION['username'];
$projectName = $_SESSION['projectName'];
$teamName = $_SESSION['teamName'];

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
<link rel = "stylesheet" href = "css/style.css">
<style>

.playGame {
    display: block;
}

.seeGame {
    display: block;
}
input[type=text] {
  font-family: 'lato', helvetica;
  font-size: 1.3em;
  line-height: 1.5;
}
.nextRound {
  margin: 2% 0;
}
.hideBeforeStart {
    display: none;
}
</style>-
</head>
<body>
    <div class = "playGame">
        <p id = "wordPrompt"></p>
        <div class = "hideBeforeStart">
          <input type = "text" id = "wordNext">
          <button id = "submit" class = "mdl-button mdl-js-button mdl-button--raised mdl-color--red">Submit</button>
        </div>
        <p id = "timer"></p>
        <button class = "nextRound mdl-button mdl-js-button mdl-button--raised mdl-color--primary">Start Round</button>
        <p id = "msg">Please enter word</p>
    </div>

    <div class = "seeGame">
        <p>Player: <span class = "player"></span></p>
        <p>Prompt: <span class = "prompt"></span></p>
        <p>Ans: <span class = "ans"></span></p>
    </div>

    <script>

        var timer;
        var word;
        var newRound = false;
        var wordList = [];
        var gameOver = 0;

        ifTurn();

        var ifTurnInt = setInterval(ifTurn, 600);

        document.querySelector('.nextRound').addEventListener('click', set);

        document.getElementById('submit').addEventListener('click', next);

        document.getElementById('wordNext').onkeydown = function(e) {
            if (e.keyCode == 13) {
                next();
            }
        }

        function set() {
            wordList = [];

            document.getElementById('submit').addEventListener('click', next);
            document.getElementById('wordNext').onkeydown = function(e) {
                if (e.keyCode === 13) {
                    next();
                }
            }

            generateWord();
            document.getElementById('wordNext').value = "";
            document.querySelector('.nextRound').style.display = "none";
            document.querySelector('.hideBeforeStart').style.display = "block";
            newRound = true;
            next();

        }

        function next() {
            document.getElementById('msg').style.display = 'none';

            if (document.getElementById('wordNext').value != '' || newRound) {
                sendData();
                newRound = false;
                gameOver = 0;

                if (wordList.includes(document.getElementById('wordNext').value.toLowerCase())) {
                    document.getElementById('timer').innerHTML = "Word already used!";
                    roundOver();
                }


                else {
                    generateWord();
                    wordList.push(document.getElementById('wordNext').value.toLowerCase());

                    if(timer) {
                        clearInterval(timer);
                        timer = false;
                    }

                    document.getElementById('wordNext').value = "";
                    if(!timer) {
                        var x = 3; //Countdown time
                        document.getElementById('timer').innerHTML = x;
                        timer = setInterval(() => {
                            if(x > 1) {
                                x -= 1;
                                document.getElementById('timer').innerHTML = x;
                            }
                            else {
                                document.getElementById('timer').innerHTML = "Time Up!!!";
                                roundOver();
                            }
                        }, 1000);
                    }
                }
            }
            else {
                //Please enter a word msg
                document.getElementById('msg').style.display = 'block';
            }
        }

        function roundOver() {
            gameOver = 1;
            sendData();
            document.getElementById('submit').removeEventListener('click', next);
            document.getElementById('wordNext').onkeydown = function(e) {}
            document.querySelector('.nextRound').style.display = "block";
            document.getElementById('msg').style.display = 'none';
            clearInterval(timer);
            timer = false;
        }

        function generateWord() {
            var xhttp = new XMLHttpRequest();
            var url = "genWord.php";
            xhttp.open("POST", url, true);

            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //New Word
                   document.getElementById('wordPrompt').innerHTML = xhttp.responseText;
                }
            };
            xhttp.send();
        }

        function ifTurn() {
            const params = "turn=1";
            var xhttp = new XMLHttpRequest();
            var url = "startGame.php";
            xhttp.open("POST", url, true);

            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (xhttp.responseText.trim() == "") {
                        document.querySelector('.playGame').style.display = "none";
                        document.querySelector('.seeGame').style.display = "block";
                        document.querySelector(".player").innerHTML = "";
                        document.querySelector(".prompt").innerHTML = "";
                        document.querySelector(".ans").innerHTML = "";
                        window.parent.postMessage("wordGameOver", "*");
                    }
                    else {
                        var userTurn = xhttp.responseText.trim();
                        if (userTurn== '<?php echo $username ?>') {
                            document.querySelector('.playGame').style.display = "block";
                            document.querySelector('.seeGame').style.display = "none";
                            window.parent.postMessage("playWord", "*");
                        }
                        else {
                            document.querySelector('.playGame').style.display = "none";
                            document.querySelector('.seeGame').style.display = "block";
                            getData();
                        }
                    }
                }
            };
            xhttp.send(params);
        }

        function sendData() {

            const params = "username=" + '<?php echo $username ?>' + "&prompt=" + document.getElementById('wordPrompt').innerHTML + "&ans=" + document.getElementById('wordNext').value + "&projectName=" + '<?php echo $projectName ?>' + "&teamName=" + '<?php echo $teamName; ?>' + "&gameOver=" + gameOver;

            var xhttp = new XMLHttpRequest();
            var url = "startGame.php";
            xhttp.open("POST", url, true);

            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                }
            };
            xhttp.send(params);
        }

        function getData() {
            const params = "username=" + '<?php echo $username ?>' + "&projectName=" + '<?php echo $projectName ?>' + "&teamName=" + '<?php echo $teamName; ?>' + "&getData=1";

            var xhttp = new XMLHttpRequest();
            var url = "startGame.php";
            xhttp.open("POST", url, true);

            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    try {
                        var data = xhttp.responseText;
                        var player = data.split("User: ")[1].split("Prompt: ")[0];
                        var prompt = data.split("User: ")[1].split("Prompt: ")[1].split("Ans: ")[0];
                        var ans = data.split("User: ")[1].split("Prompt: ")[1].split("Ans: ")[1];

                        document.querySelector(".player").innerHTML = player;
                        document.querySelector(".prompt").innerHTML = prompt;
                        document.querySelector(".ans").innerHTML = ans;
                    }
                    catch(e) {

                    }

                }
            };
            xhttp.send(params);
        }

        function wordGame() {

            const params = "startGame=1";

            var xhttp = new XMLHttpRequest();
            var url = "startGame.php";
            xhttp.open("POST", url, true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                }
            };
            xhttp.send(params);

            var gameButtons = document.querySelectorAll(".games button");
            //Disable buttons
            for (var i = 0; i < gameButtons.length; i++) {
                gameButtons[i].disabled = true;
            }
        }

     </script>
</body>
</html>
