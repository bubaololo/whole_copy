<?php

require_once '../../bootstrap.php';



$path = '';
echo 'begin process ' . $path . PHP_EOL;
// $fullPath = DOMAIN . $path;
$fullPath = getFilesPath('local') . DIRECTORY_SEPARATOR . 'index.html';
$rawHtml = file_get_contents($fullPath);
// $rawHtml = html_entity_decode($rawHtml);
// file_put_contents('test.html', $rawHtml);

$page = getFullPage($rawHtml);

foreach($page->find('title') as $e) {
    $titles[$path] = $e->innertext;
    echo $e->innertext . PHP_EOL;
}

foreach($page->find('meta[name=description]') as $e) {
    $descriptions[$path] = $e->content;
    echo $e->content . PHP_EOL;
}


$readyPageContent =  processPageContent($page);


// foreach ($page->find('img') as $e) {
//     $src = $e->src;
//     echo 'finded img ' . $src . PHP_EOL;
//     if ($src == "") {
//         break;
//     }
//     if (str_starts_with($src, '//')) {

//         $src = str_replace('//', 'https://', $src);
//     }
//     if (str_starts_with($src, '/')) {

//         $src = DOMAIN . $src;
//     }
//     if ($e->srcset) {
//         $e->removeAttribute('srcset');
//     }
//     $newsrc = saveImg($src);
//     $e->src = $newsrc;

// }



$page->save('temp.html');

