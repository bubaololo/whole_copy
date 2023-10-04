<?php

include "simple_html_dom.php";
$rawcontent = file_get_contents('footer.php');
$html = str_get_html($rawcontent);
$url='https://play.pokerok900.com/';
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

    $all_filenames = scandir('img');
    $filename = pathinfo($src, PATHINFO_BASENAME);
    if(in_array($filename, $all_filenames)) {
        $filename=uniqid().$filename;
    };

    $newpath = "img\\$filename";
    $e->src = $newpath;
    file_put_contents($newpath, file_get_contents($src));

    echo $src.PHP_EOL;
    // echo "<br>";
}
$html->save('yo.html');
// $rendered_html = file_get_contents('yo.html');

// file_put_contents('index1.php',$final_file_content);
