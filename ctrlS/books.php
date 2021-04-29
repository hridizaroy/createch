<?php

require 'genWordFunc.php';
$keywords = "";
function getBooks() {
    global $keywords, $textSplit, $punctuations, $stopWords;
    $list = array();
    $keywords = generateWord($textSplit, $punctuations, $stopWords);
    array_push($list, $keywords);

    for ($i = 0; $i < 3; $i++) {
        $word = generateWord($textSplit, $punctuations, $stopWords);
        while (in_array($word, $list)) {
            $word = generateWord($textSplit, $punctuations, $stopWords);
        }
        $keywords.='+'.$word;
        array_push($list, $word);
    }    
    
    $doc = new \DOMDocument();
    $url = utf8_encode('https://www.google.com/search?q='.$keywords.'&tbm=bks');
    $doc->loadHTMLFile($url);
    $links = $doc->getElementsByTagName("a");

    foreach($links as $book) {
        if($book->firstChild->tagName == "h3") {
            $href =  $book->getAttribute("href");
            $link = trim(preg_replace("/[\r\n]+/", " ", $book->firstChild->nodeValue));
            echo "<a href = '".$href."'>$link</a><br><br>";
        }
    }

    $keywords_split = implode(" ", explode("+", $keywords));
    echo "<p>Search: ".$keywords_split."</p>";
}

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
    </head>
    <body>
        <p>Books</p>
        <?php
            @getBooks();
                   
        ?>

        <p class = "errMsg"></p>

        <script>
            if (document.querySelector("a") == null) {
                document.querySelector(".errMsg").innerText = "No results for the search. Please try again.";
                location.reload();
            }
        </script>
    </body>

</html>