
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

    $teamName = $_SESSION['teamName'];
    $projectName = $_SESSION['projectName'];
?>

<html>
    <head>
        <title>Draw</title>

        <style>
            .point {
                position: absolute;
                border-radius: 50%;
                background-color: #000;
                width: 10px;
                height: 10px;
            }

            #canvas {
                background-color: #fff;
                
            }
            .over {
                display: none;
            }
        </style>
    </head>

    <body>

        <div class = "playGame">
            <p id = "toDraw"></p>
            <canvas id = "canvas"></canvas>
        </div>

        <div class = "seeGame">
            <p>Player: <span class = "player"></span></p>
            <div id = "image">
                <img>
            </div>
            <input type = 'text' class = 'guess'>
            <p class = 'msg'></p>
        </div>

        <p class = "over">Game Over</p>

        <script src="https://cdn.jsdelivr.net/processing.js/1.4.8/processing.min.js"></script>

        <script>
            
            var gameOver = 0;

            var sketchProc = function (processingInstance) {
                with (processingInstance) {
                    size(innerWidth - 30, innerHeight-175);
                    frameRate(30);

                    function paint() {
                        stroke(0, 0, 0);
                        fill(0, 0, 0);
                        ellipse(mouseX, mouseY, 10, 10);
                        sendImg();
                    }

                    var draw = function(){
                        
                        mouseDragged = function () {
                            paint();
                        }

                        mouseClicked = function(){
                            paint();
                        }

                    }

                }
            };

            document.querySelector('.guess').onkeydown = function(e) {
                if (e.keyCode == 13) {
                    check();
                }
            }


            var canvas = document.getElementById("canvas"); 

            var processingInstance = new Processing(canvas, sketchProc); 


            function sendImg() {

                const params = "pic=" + canvas.toDataURL('image/png') + "&word=" + document.getElementById('toDraw').innerHTML;

                var xhttp = new XMLHttpRequest();
                var url = "drawData.php";
                xhttp.open("POST", url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        
                    }
                };
                xhttp.send(params);
            }

            function generateWord() {
                var xhttp = new XMLHttpRequest();
                var url = "genWord.php";
                xhttp.open("POST", url, true);

                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        //New Word
                        document.getElementById('toDraw').innerHTML = xhttp.responseText;
                    }
                };
                xhttp.send();
                setTimeout(()=>{
                    gameOver = 1;
                    gameUp();
                }, 60000);
            }


            setInterval(getImg, 100);

            var image = document.querySelector('#image img');

            function getImg() {

                var xhttp = new XMLHttpRequest();
                var url = "getDrawing.php";
                xhttp.open("POST", url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var newSrc = "data:image/png;base64," + xhttp.responseText;
                        if (image.src != newSrc) {
                            image.src = newSrc;
                        }                        
                    }
                };
                xhttp.send();
            }

            var ifTurnInt = setInterval(ifTurn, 1000);

            function ifTurn() {
                const params = "turn=1";
                var xhttp = new XMLHttpRequest();
                var url = "startGameDraw.php";
                xhttp.open("POST", url, true);

                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if (xhttp.responseText.trim() == "") {
                            document.querySelector('.playGame').style.display = "none";
                            document.querySelector('.seeGame').style.display = "none";
                            document.querySelector('.over').style.display = "block";
                            window.parent.postMessage("drawGameOver", "*");
                        }
                        else {
                            var userTurn = xhttp.responseText.trim();
                            if (userTurn == '<?php echo $username ?>') {
                                document.querySelector('.playGame').style.display = "block";
                                document.querySelector('.seeGame').style.display = "none";
                                if (document.getElementById('toDraw').innerHTML == "") {
                                    generateWord();
                                }
                                window.parent.postMessage("playDraw", "*");
                            }
                            else {
                                document.querySelector('.player').innerHTML = userTurn;
                                document.querySelector('.playGame').style.display = "none";
                                document.querySelector('.seeGame').style.display = "block";
                                document.getElementById('toDraw').innerHTML = "";
                            }
                            document.querySelector('.over').style.display = "none";
                        }
                    }
                };
                xhttp.send(params);     
            }

            function gameUp() {
                const params = "username=" + document.querySelector('.player').innerHTML + "&word=" + document.getElementById('toDraw').innerHTML + "&projectName=" + '<?php echo $projectName ?>' + "&teamName=" + '<?php echo $teamName; ?>' + "&gameOver=" + gameOver;

                var xhttp = new XMLHttpRequest();
                var url = "startGameDraw.php";
                xhttp.open("POST", url, true);

                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        
                    }
                };
                xhttp.send(params);
            }

            function check() {
                if (document.querySelector('.guess').value.trim() != '') {
                    const params = "username=" + document.querySelector('.player').innerHTML + "&guess=" + document.querySelector('.guess').value + "&projectName=" + '<?php echo $projectName ?>' + "&teamName=" + '<?php echo $teamName; ?>';

                    var xhttp = new XMLHttpRequest();
                    var url = "startGameDraw.php";
                    xhttp.open("POST", url, true);

                    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            if (xhttp.responseText == 1) {
                                document.querySelector('.msg').innerHTML = 'Well done!';
                                gameOver = 1;
                                gameUp();
                            }
                            else {
                                document.querySelector('.msg').innerHTML = 'Nope. Try again.';
                            }
                        }
                    };
                    xhttp.send(params);
                }
            }
        
        </script>

    </body>

</html>