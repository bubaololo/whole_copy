<?php

require_once '../../bootstrap.php';



$path = '';
echo 'begin process ' . $path . PHP_EOL;
// $fullPath = DOMAIN . $path;
$fullPath = getFilesPath('local') . DIRECTORY_SEPARATOR . 'index.html';
$rawHtml = file_get_contents($fullPath);
// $rawHtml = html_entity_decode($rawHtml);
// file_put_contents('test.html', $rawHtml);
$rawHtml = str_replace('&quot;', "'", $rawHtml);
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





$page->save('temp.html');

