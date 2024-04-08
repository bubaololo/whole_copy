<?php

require_once '../../bootstrap.php';


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

    foreach ($page->find('title') as $e) {
        $titles[$url] = $e->innertext;
        echo $e->innertext . PHP_EOL;
    }

    foreach ($page->find('meta[name=description]') as $e) {
        $descriptions[$url] = $e->content;
        echo $e->content . PHP_EOL;
    }

    // $content = $page->find('main')[0];
    $content = getContentNode($rawHtml, 'main');

    $readyPageContent =  processPageContent($content)->save();

    $final_file_content = '<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/header.php"); ?>' . $readyPageContent . '<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/footer.php"); ?>';

    $filePathToSave = getFilesPath('ready') . $url;

    if (!is_dir($filePathToSave)) {
        mkdir($filePathToSave, 0777, true);
    }

    $finalFilePath = $filePathToSave . DIRECTORY_SEPARATOR . 'index.php';

    file_put_contents($finalFilePath, $final_file_content);
}

file_put_contents(getFilesPath() . DIRECTORY_SEPARATOR . 'titles.json', json_encode($titles));
file_put_contents(getFilesPath() . DIRECTORY_SEPARATOR . 'descriptions.json', json_encode($descriptions));
