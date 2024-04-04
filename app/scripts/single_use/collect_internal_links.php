<?php

require_once '../../../bootstrap.php';






foreach ($urls as $url) {
    echo 'begin process ' . $url . PHP_EOL;
    
    $url = str_replace('/', DIRECTORY_SEPARATOR, $url);

    // $fullPath = DOMAIN . $path;
    $fullPath = getFilesPath('local') . $url . DIRECTORY_SEPARATOR . 'index.html';
    $rawHtml = file_get_contents($fullPath);
    // $rawHtml = html_entity_decode($rawHtml);
    // file_put_contents('test.html', $rawHtml);
    $rawHtml = str_replace('&quot;', "'", $rawHtml);
    $page = getFullPage($rawHtml);
    
    foreach ($page->find('a') as $link) {
        $internalLinks[] = $link->href;
    }
    
    
}

//file_put_contents(getFilesPath() . DIRECTORY_SEPARATOR . 'titles.json', json_encode($titles));
//file_put_contents(getFilesPath() . DIRECTORY_SEPARATOR . 'descriptions.json', json_encode($descriptions));
file_put_contents(getFilesPath() . DIRECTORY_SEPARATOR . 'internal_links.json', json_encode(array_unique($internalLinks)));
