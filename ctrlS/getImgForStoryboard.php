<?php

require 'genWordFunc.php';
$keywords = "";
function getImg() {
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
    $url = utf8_encode('https://www.google.com/search?q='.$keywords.'&tbm=isch');
    $doc->loadHTMLFile($url);
    $images = $doc->getElementsByTagName("img");

    $i= mt_rand(1, count($images) - 1);
    $src =  $images[$i]->getAttribute("src");
    $keywords_split = implode(" ", explode("+", $keywords));
    echo "<p>".$keywords_split."</p>";
    echo "<img src = '".$src."'>";
}

?>

<html>
    <body>
        <?php
            for ($x = 0; $x < 3; $x ++) {
                @getImg();
            }        
        ?>
    </body>

</html>