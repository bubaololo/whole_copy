<?php

include "simple_html_dom.php";
include "functions" . DIRECTORY_SEPARATOR . "fetch.php";
$rawcontent = file_get_contents('header.html');
$html = str_get_html($rawcontent);
$url='https://www.888poker.com';
foreach($html->find('img') as $e) {
    $src = $e->src;
    if (str_contains($src, 'yandex')) {
        $e->src = '';
        continue;
    }
    if(str_starts_with($src, '//')) {

        $src = str_replace('//', 'https://', $src);
    }
    if(str_starts_with($src, '/')) {

        $src = $url.$src;
    }
    $filename = pathinfo($src, PATHINFO_BASENAME);

    $newpath = saveImg($src);
    $e->src = $newpath;
    $realpath = $sourceSiteDir . "\\img\\$filename";
    file_put_contents($realpath, file_get_contents($src));

    echo $src.PHP_EOL;
    // echo "<br>";
}
$html->save('yo.html');
// $rendered_html = file_get_contents('yo.html');

// file_put_contents('index1.php',$final_file_content);
