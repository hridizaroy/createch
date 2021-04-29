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

    require 'functions.php';

    if (isset($_POST['projectName'])) {
        $_SESSION['projectName'] = $_POST['projectName'];
        $_SESSION['teamName'] = $_POST['teamName'];
    }

    $file_to_open = $file = $fileContent = $nowOpen = "";

    $teamName = $_SESSION['teamName'];
    $projectName = $_SESSION['projectName'];

    $files = listFiles($teamName, $projectName);

    $fileDir = $teamName."/$projectName/files/";

    function open() {
        global $file_to_open, $fileDir, $file, $fileContent, $nowOpen;

        $file_to_open = $nowOpen = $_POST['toOpenFileName'];

        $file = fopen($fileDir.$file_to_open, "r");

        if (filesize($fileDir.$file_to_open) > 0) {
            $fileContent = fread($file, filesize($fileDir.$file_to_open));
            fclose($file);
            echo $fileContent;
        }
        else {
            echo "";
        }
    }

?>


<html>
    <head>
        <title>Open File</title>
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
        <link rel = "stylesheet" href = "css/style.css">
        <style>
            .chatwindow {
                position: absolute;
                top: 0;
                right: 0;
                height: 100%;
                width: 20%;
                border: 1px solid #000;
            }

            .send {
                position: absolute;
                bottom: 0;
            }

            .chat {
                width: 100%;
                height: 5%;
                min-height: 35px;
                padding-top: 1%;
                padding-bottom: 1%;
                max-height: 150px;
            }

            .msgContainer {
                display: block;
            }

            .msg {
                padding: 2% 6%;
                margin: 10px 5px;
                border: 0.5px solid #000;
                display: inline-block;
            }

            .msgs {
                height: 77%;
                overflow: auto;
            }

            .date {
                margin: auto;
                text-align: center;
            }

            .title {
                margin: 0;
            }

            .files li {
                cursor: pointer;
            }

            .gameFrame {
                display: none;
            }

            .recCont {
                width: 20%;
                display: inline-block;
            }

            .recButton {
                width: 100%;
                float: left;
            }

            .recButton:hover {
                color: #fff;
            }

            .recOpts {
                display: none;
                width: 100%;
                transition: 0.6s;
            }

            .recOpts li {
                display: block;
                list-style: none;
                text-align: center;
                background-color: rgb(29, 212, 151);
                font-size: 1em;
                color: #fff;
            }

            .recOpts li:hover {
                color: #aaa;
            }
            .recCont li::before {
                content: '';
            }

            .recFrameCont {
                display: inline-block;
                margin: 0 5%;
                width: 40%;
            }

            .recFrame {
                display: none;
            }

            .newFile {
                float: left;
                margin-top: 1%;
            }

            .closeRec {
                display: none;
                margin: auto;
                text-align: center;
            }

        </style>
    </head>
    <body>

        <div class = "session" hidden>
            <p id = "s_user"><?php echo $username ?></p>
            <p id = "s_team"><?php echo $teamName ?></p>
            <p id = "s_project"><?php echo $projectName ?></p>
        </div>

        <div class = "fileArea">

            <!-- Project and team details -->
            <p>Team: <?php echo explode(";", $teamName)[0] ?></p>
            <p>Project: <?php echo $projectName ?></p>

            <!--Files-->
            <ul class = "files">
            <?php
                for ( $i = 0; $i < count($files); $i++ ) {
                    echo "<li>".$files[$i]."</li>";
                }
                if (count($files) == 0) {
                    echo "<p>No files in this project</p>";
                }
            ?>
            </ul>
            <!--New File Button-->
            <button class = "newFile mdl-button mdl-js-button mdl-button--raised mdl-color--primary">New File</button>

            <!--Recommendations-->
            <ul class = "recCont">
                <li><button class = "recButton mdl-button mdl-js-button mdl-button--raised mdl-color--primary">Recommendations</button></li>

                <div class = "recOpts">
                    <li class = "mdl-button mdl-js-button mdl-button--raised">Movies</li>
                    <li class = "mdl-button mdl-js-button mdl-button--raised">TV Shows</li>
                    <li class = "mdl-button mdl-js-button mdl-button--raised">Youtube videos</li>
                    <li class = "mdl-button mdl-js-button mdl-button--raised">Books</li>
                </div>
            </ul>
                <div class = "recFrameCont">
                    <iframe src = "movies.php" class = "recFrame"></iframe>
                    <iframe src = "tvShows.php" class = "recFrame">></iframe>
                    <iframe src = "ytvids.php" class = "recFrame">></iframe>
                    <iframe src = "books.php" class = "recFrame">></iframe>
                    <button class = "closeRec mdl-button mdl-js-button mdl-button--raised">Close</button>
                </div>



            <!--For opening a file-->
            <form class = "openName" action = "newfile.php" target="newfile.php" method = "post">
                <input type = "text" name = "toOpenFileName" hidden>
            </form>

            <form action = "newfile.php" target="newfile.php" method = "post" id = "openName">
                <textarea type = "text" name = "openedFile" id = "openedFile"><?php
                    if ( isset($_POST['toOpenFileName']) ) {
                        open();
                    }
                ?>
                </textarea>
                <input class = "nowOpen" id = "openFileName" name = "openFileName" value = "<?php echo $nowOpen ?>" hidden>
            </form>

            <!--Name of currently open file-->
            <div class = "nowOpen"><p><?php echo $nowOpen ?></p></div>

            <!--Displaying currently active users for the project-->
            <p>Active now: <span class = "activeNow"></span></p>
            <p><a href = "home.php">Home</a></p>
            <p><a href = "logout.php">Log out</a></p>

            <!--Games-->
            <div class = "games">
                <button class = "wordGame mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--red">3s Words</button>
                <button class = "drawGame mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--red">Draw the word</button>
                <button class = "storyBoard mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--red">Story board</button>
                <p>Minimum players: 2</p>
            </div>

        </div>


        <!--Chat Window-->
        <div class = "chatwindow">
            <p class = "mdl-color--primary mdl-shadow--2dp title">Chat</p>
            <div class = "msgs">
            </div>
            <!--Send content-->
            <div class = "send">
                <textarea type = "text" class = "chat"></textarea>
                <button class = "sendButton mdl-button mdl-js-button mdl-button--raised">Send</button>
                <input name = "user" value = '<?php echo $username ?>' class = "user" hidden>
            </div>
        </div>



        <iframe src = "wordGamev1.php" class = "gameFrame" id = "wordGame"></iframe>
        <iframe src = "draw.php" class = "gameFrame" id = "drawGame"></iframe>
        <iframe src = "getImgForStoryboard.php" class = "gameFrame" id = "storyBoard"></iframe>

        <script>

            var file = document.getElementById('openName');
            var openedFile = document.getElementById('openedFile');
            var nowOpen = document.querySelector(".nowOpen p").innerText;
            var wordGameFrame = document.getElementById('wordGame');
            var drawGameFrame = document.getElementById('drawGame');
            var storyBoardFrame = document.getElementById('storyBoard');
            var updateInterval;
            var getUpdatedInterval;
            var gameOn = false;

            var files = document.querySelectorAll(".files li");

            var gameButtons = document.querySelectorAll(".games button");

            //Disable buttons
            for (var i = 0; i < gameButtons.length; i++) {
                gameButtons[i].disabled = true;
            }

            for (var i = 0; i < gameButtons.length; i++) {
                gameButtons[i].addEventListener('click', showGame);
            }

            var recOpts = document.querySelectorAll(".recOpts li");
            
            for (var i = 0; i < recOpts.length; i++) {
                recOpts[i].addEventListener('click', showRec);
            }

            document.querySelector('.recCont').addEventListener('mouseenter', showRecOpts);

            document.querySelector('.recCont').addEventListener('mouseleave', hideRecOpts);

            document.querySelector(".closeRec").addEventListener('click', hideRecs);

            function showRecOpts() {
                document.querySelector('.recOpts').style.display = "block";
            }

            function hideRecOpts() {
                document.querySelector('.recOpts').style.display = "none";
            }

            function hideRecs() {
                var recFrames = document.querySelectorAll('.recFrame');

                for (var i = 0; i < recFrames.length; i++) {
                    recFrames[i].style.display = "none";
                    hideRecOpts();
                }
                document.querySelector('.recCont').addEventListener('mouseleave', hideRecOpts);

                document.querySelector(".closeRec").style.display = "none";
            }

            function showRec() {
                
                showRecOpts();

                document.querySelector('.recCont').removeEventListener('mouseleave', hideRecOpts);

                var x = Array.prototype.indexOf.call(this.parentNode.children, this);
                var recFrames = document.querySelectorAll('.recFrame');

                for (var i = 0; i < recFrames.length; i++) {
                    recFrames[i].style.display = "none";
                }
               
                recFrames[x].style.display = "block";
                document.querySelector(".closeRec").style.display = "block";
            }

            function showGame() {
                var gameFrames = document.getElementsByClassName('gameFrame');
                for (var x = 0; x < gameFrames.length; x++) {
                    gameFrames[x].style.display = "none";
                }
                document.querySelector('#openFileName').value = "";
                document.querySelector('#openedFile').value = "";
                document.querySelector('.nowOpen p').innerText = "";
                openedFile.style.display = "none";

                document.getElementById(this.classList.item(0)).style.display = "block";
            }

            function open() {
                var openValue = document.querySelector(".openName input");
                openValue.value = this.innerText;
                document.querySelector(".openName").submit();
            }

            for ( var i = 0; i < files.length; i++) {
                files[i].addEventListener('click', open);
            }

            if (nowOpen !== "") {
                openedFile.style.display = "block";
                openedFile.addEventListener('input', update);
                getUpdatedInterval = setInterval(getUpdated, 500);
            }
            else {
                openedFile.style.display = "none";
            }

            function update() {

                clearInterval(getUpdatedInterval);
                const params1 = "openedFile=" + document.querySelector('#openedFile').value + "&openFileName=" + document.querySelector('#openFileName').value + "&projectName=" + '<?php echo $projectName ?>' + "&teamName=" + '<?php echo $teamName; ?>';

                var xhttp1 = new XMLHttpRequest();
                var url = "update.php";
                xhttp1.open("POST", url, true);
                xhttp1.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp1.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Updated
                        getUpdatedInterval = setInterval(getUpdated, 500);
                    }
                };
                xhttp1.send(params1);
            }

            function getUpdated() {

                const params2 = "openFileName=" + document.querySelector('#openFileName').value + "&projectName=" + '<?php echo $projectName ?>' + "&teamName=" + '<?php echo $teamName; ?>';

                var xhttp2 = new XMLHttpRequest();
                var url = "open.php";
                xhttp2.open("POST", url, true);
                xhttp2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp2.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(!(xhttp2.responseText.startsWith("<") || xhttp2.responseText === openedFile.value)){
                            var caretPos = getCaretPosition(openedFile);
                            openedFile.value = xhttp2.responseText;
                            setCaretPosition(openedFile, caretPos);
                        }
                    }
                };
                xhttp2.send(params2);
            }

            function getCaretPosition(elem) {
                var startPos = elem.selectionStart;
                var endPos = elem.selectionEnd;
                return startPos;
            }

            function setCaretPosition(elem, caretPos) {
                if(elem.createTextRange) {
                    var range = elem.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', caretPos);
                    range.moveStart('character', caretPos);
                    range.select();
                    return;
                }

                if(elem.selectionStart) {
                    elem.focus();
                    elem.setSelectionRange(caretPos, caretPos);
                }
            }

            document.querySelector(".chat").addEventListener('input', print);

            function print() {
                var sh = document.querySelector(".chat").scrollHeight;
                var ch = document.querySelector(".chat").clientHeight;
                document.querySelector(".chat").style.height = sh + "px";
                if (ch < 148) {
                    document.querySelector(".chat").style.overflow = "hidden";
                }
                else {
                    document.querySelector(".chat").style.overflow = "auto";
                }
            }

            document.querySelector(".sendButton").addEventListener('click', send);
            var updateChatsInterval = setInterval(getChats, 500);

            var chats = "";

            function send() {

                if (document.querySelector('.chat').value != "") {

                    var date = new Date();
                    var day = date.getDate();
                    var month = date.getMonth();
                    var year = date.getFullYear();
                    var h = date.getHours();
                    var m = date.getMinutes();
                    if (m < 10) {
                        m = "0" + String(m);
                    }
                    var time = h + ":" + m;
                    var fullDate = String(day) + "/" + String(month) + "/" + String(year);
                    var fileName = '<?php echo $projectName?>';

                    const params3 = "user=" + document.querySelector('.user').value + "&chatContent=" + document.querySelector('.chat').value + "&time=" + time + "&fileName=" + fileName + "&fullDate=" + fullDate + "&teamName=" + '<?php echo $teamName; ?>';

                    var xhttp3 = new XMLHttpRequest();
                    var url = "chat.php"; //tried to change page
                    xhttp3.open("POST", url, true);

                    xhttp3.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhttp3.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            // Updated
                        }
                    };
                    xhttp3.send(params3);

                    document.querySelector(".chat").value = "";
                    document.querySelector(".chat").style.height = "35px";

                }
            }

            function getChats(){

                var fileName = '<?php echo $projectName?>';

                const params4 = "fileName=" + fileName + "&teamName=" + '<?php echo $teamName; ?>';

                var xhttp4 = new XMLHttpRequest();
                var url = "getChats.php";
                xhttp4.open("POST", url, true);

                xhttp4.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp4.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(!(xhttp4.responseText.startsWith("<") || xhttp4.responseText === chats)) {

                            var msg, user, msgTime, msgDate;
                            var updateChats = xhttp4.responseText;
                            chats = updateChats;

                            updateChats = updateChats.split("Msg: ");

                            var dates = document.body.getElementsByClassName('date');

                            document.querySelector(".msgs").innerHTML = "";

                            for (var i = 1; i < updateChats.length; i++){
                                msg = updateChats[i].split("User: ")[0];
                                user = updateChats[i].split("User: ")[1].split("Time: ")[0];
                                msgTime = updateChats[i].split("User: ")[1].split("Time: ")[1].split("Date: ")[0];
                                msgDate = updateChats[i].split("User: ")[1].split("Time: ")[1].split("Date: ")[1];

                                var container = document.createElement("div");
                                container.classList.add("msgContainer");

                                user = user.trim();

                                if (user == '<?php echo $username?>') {
                                    container.style.textAlign = "right";
                                }
                                else {
                                    container.style.textAlign = "left";
                                }

                                var dateP = document.createElement("p");
                                dateP.classList.add("date");

                                var dateRepeat = false;

                                for (var t = 0; t < dates.length; t++) {
                                    if (dates[t].innerHTML === msgDate) {
                                        dateRepeat = true;
                                        break;
                                    }
                                }

                                if (!(dateRepeat)) {
                                    dateP.innerHTML = msgDate;
                                    container.appendChild(dateP);
                                }

                                var newMsg = document.createElement("div");
                                newMsg.classList.add("msg");

                                var content = document.createElement("div");
                                content.classList.add("content");
                                content.innerHTML = msg;
                                var memberName = document.createElement("div");
                                memberName.classList.add("memberName");
                                memberName.innerHTML = user;
                                var timeOfMsg = document.createElement("div");
                                timeOfMsg.classList.add("time");
                                timeOfMsg.innerHTML = msgTime;

                                newMsg.appendChild(content);
                                newMsg.appendChild(memberName);
                                newMsg.appendChild(timeOfMsg);

                                container.appendChild(newMsg);

                                document.querySelector(".msgs").appendChild(container);

                                document.querySelector(".msgs").scrollTop = document.querySelector(".msgs").scrollHeight;
                            }
                        }
                    }
                };
                xhttp4.send(params4);
            }

            document.querySelector(".newFile").addEventListener('click', newFile);
            document.querySelector(".wordGame").addEventListener('click', wordGame);
            document.querySelector(".drawGame").addEventListener('click', drawGame);

            function newFile() {

                const params5 = "projectName=" + '<?php echo $projectName ?>' + "&teamName=" + '<?php echo $teamName; ?>';

                var xhttp5 = new XMLHttpRequest();
                var url = "addFile.php";
                xhttp5.open("POST", url, true);
                xhttp5.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp5.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        location.href = url;
                    }
                };
                xhttp5.send(params5);
            }

            function setActive() {
                const params = "projectName=" + '<?php echo $projectName ?>' + "&teamName=" + '<?php echo $teamName; ?>' + "&username=" + '<?php echo $username; ?>';

                var xhttp = new XMLHttpRequest();
                var url = "activeMembers.php";
                xhttp.open("POST", url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.querySelector(".activeNow").innerHTML = xhttp.responseText;
                        if (!gameOn) {
                            gameOpts();
                        }
                    }
                };
                xhttp.send(params);
            }

            setInterval(setActive, 500);

            function gameOpts() {
                var activeNow = document.querySelector(".activeNow").innerText.split(",");
                var gameButtons = document.querySelectorAll(".games button");
                if (activeNow.length >= 2) {
                    //Enable buttons
                    for (var i = 0; i < gameButtons.length; i++) {
                        gameButtons[i].disabled = false;
                    }
                }
                else {
                    //Disable buttons
                    for (var i = 0; i < gameButtons.length; i++) {
                        gameButtons[i].disabled = true;
                    }
                }
            }

            function wordGame() {

                const params = "startGame=1";

                var xhttp = new XMLHttpRequest();
                var url = "startGame.php";
                xhttp.open("POST", url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        gameOn = true;
                    }
                };
                xhttp.send(params);

                var gameButtons = document.querySelectorAll(".games button");
                //Disable buttons
                for (var i = 0; i < gameButtons.length; i++) {
                    gameButtons[i].disabled = true;
                }
            }

            function drawGame() {

                const params = "startGame=1";

                var xhttp = new XMLHttpRequest();
                var url = "startGameDraw.php";
                xhttp.open("POST", url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        gameOn = true;
                    }
                };
                xhttp.send(params);

                var gameButtons = document.querySelectorAll(".games button");
                //Disable buttons
                for (var i = 0; i < gameButtons.length; i++) {
                    gameButtons[i].disabled = true;
                }
            }

            var ifTurnWG = wordGameFrame.ownerDocument.querySelector('.playGame');

            window.addEventListener("message", receiveMessage);
            var game;
            var wordGameIndi = false;
            var drawGameIndi = false;

            function receiveMessage(event) {
                if (event.data != game) {
                    game = event.data;
                    if (game == "playWord") {
                        var gameFrames = document.getElementsByClassName('gameFrame');
                        for (var x = 0; x < gameFrames.length; x++) {
                            gameFrames[x].style.display = "none";
                        }
                        document.querySelector('#openFileName').value = "";
                        document.querySelector('#openedFile').value = "";
                        document.querySelector('.nowOpen p').innerText = "";
                        openedFile.style.display = "none";

                        document.getElementById('wordGame').style.display = "block";
                        //Disable buttons
                        for (var i = 0; i < gameButtons.length; i++) {
                            gameButtons[i].disabled = true;
                        }
                        wordGameIndi = true;
                        drawGameIndi = false;
                        gameOn = true;
                    }
                    else if (game == "playDraw") {
                        var gameFrames = document.getElementsByClassName('gameFrame');
                        for (var x = 0; x < gameFrames.length; x++) {
                            gameFrames[x].style.display = "none";
                        }
                        document.querySelector('#openFileName').value = "";
                        document.querySelector('#openedFile').value = "";
                        document.querySelector('.nowOpen p').innerText = "";
                        openedFile.style.display = "none";

                        document.getElementById('drawGame').style.display = "block";
                        //Disable buttons
                        for (var i = 0; i < gameButtons.length; i++) {
                            gameButtons[i].disabled = true;
                        }
                        wordGameIndi = false;
                        drawGameIndi = true;
                        gameOn = true;
                    }
                    else if (game == "wordGameOver") {
                        wordGameIndi = false;
                    }
                    else if (game == "drawGameOver") {
                        drawGameIndi = false;
                    }
                    if (!wordGameIndi && !drawGameIndi) {
                        gameOn = false;
                    }
                }
            }

        </script>
    </body>
</html>
