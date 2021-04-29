<?php

require 'genWordFunc.php';
$keywords = "";
$arr_list = array();
$num = 0;

function movies() {
    global $keywords, $textSplit, $punctuations, $stopWords, $arr_list, $num;
    $list = array();
    $keywords = generateWord($textSplit, $punctuations, $stopWords);
    array_push($list, $keywords);

    for ($i = 0; $i < 1; $i++) {
        $word = generateWord($textSplit, $punctuations, $stopWords);
        while (in_array($word, $list)) {
            $word = generateWord($textSplit, $punctuations, $stopWords);
        }
        $keywords.='+'.$word;
        array_push($list, $word);
    }

    $api_key = '5607b0a4796238fb9c5a732b0350e500';

    $order = "relevance";
    $maxResults = 5;
        
    $url = "https://api.themoviedb.org/3/search/movie?api_key=$api_key&query=$keywords";

    $arr_list = getMoviesList($url);

}

function getMoviesList($api_url = '') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $arr_result = json_decode($response);
    if (isset($arr_result->results)) {
        return $arr_result;
    } else {
        echo "Something went wrong.";
    }
}

function getMovies() {
    global $keywords, $textSplit, $punctuations, $stopWords, $arr_list, $num;
    $max = 5;

    movies();

    if (!empty($arr_list)) {
        echo '<ul>';
        foreach ($arr_list->results as $movie) {
            echo "<li>". $movie->original_title ."</li>";
            $num++;
        }
        echo '</ul>';
    }
    for ($i = 0; $i < $max; $i++) {
        if ($num == 0) {
            movies();
        }
        else {
            break;
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
        <p>Movies</p>
        <?php
            @getMovies();
        ?>

        <p class = "errMsg"></p>

        <script>
            if (document.querySelector("li") == null) {
                document.querySelector(".errMsg").innerText = "No results for the search. Please try again.";
                location.reload();
            }
        </script>

    </body>

</html>