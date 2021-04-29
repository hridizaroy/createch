<?php

require 'genWordFunc.php';
$keywords = "";
function getVids() {
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



    $developer_key = 'AIzaSyBykCdc2faZPrljKuYy8kGbQOWDoGHfD2Q';

    $order = "relevance";
    $maxResults = 5;
 
    $arr_list = array();
        
    $url = "https://www.googleapis.com/youtube/v3/search?q=$keywords&order=$order"."&part=snippet&type=video&maxResults=$maxResults"."&key=". $developer_key;

    $arr_list = getYTList($url);

    if (!empty($arr_list)) {
        echo '<ul>';
        foreach ($arr_list->items as $yt) {
            echo "<li>". $yt->snippet->title ."</li>";
            echo "<a href = 'https://www.youtube.com/watch?v=".$yt->id->videoId."'>Video</a><br>";
            echo "<img src = 'https://img.youtube.com/vi/".$yt->id->videoId."/default.jpg'>";
        }
        echo '</ul>';
    }
    $keywords_split = implode(" ", explode("+", $keywords));
    echo "<p>Search: ".$keywords_split."</p>";
}

function getYTList($api_url = '') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $arr_result = json_decode($response);
    if (isset($arr_result->items)) {
        return $arr_result;
    } elseif (isset($arr_result->error)) {
        echo "Something went wrong.";
    }
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
        <p>Youtube Videos</p>
        <?php
            @getVids();    
        ?>
    </body>

</html>