<?php
set_time_limit(0);
define('MAX_FILE_SIZE', 12000000);
include "simple_html_dom.php";
include "functions" . DIRECTORY_SEPARATOR . "fetch.php";
libxml_use_internal_errors(TRUE);
const DOMAIN = 'https://wptglobal.com';
const LOCAL_SOURCES_DIR = 'local_sources';
const READY_FILES_DIR = 'ready';
$currentDir = __DIR__;

// Переходим на уровень выше
$parentDir = dirname($currentDir);


$sourceSiteDir = $parentDir . DIRECTORY_SEPARATOR . LOCAL_SOURCES_DIR;

$readySiteFiles = $parentDir . DIRECTORY_SEPARATOR . READY_FILES_DIR;


$paths = [
    "/"
];
$paths = array_unique($paths);
$internalLinks = [];
$titles = [];
$descriptions = [];
$options = array(
    'http' => array(
        'method' => "GET",
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3\r\n",
    ),
);

$context = stream_context_create($options);
foreach ($paths as $path) {
    echo 'begin process ' . $path . PHP_EOL;
    $fullPath = $sourceSiteDir . str_replace('/', '\\', $path) . "index.html";
    // $fullPath = DOMAIN . $path;

    if (($raw = @file_get_contents($fullPath, false, $context)) === false) {
        $error = error_get_last();
        echo "HTTP request failed. Error was: " . $error['message'] . PHP_EOL;
        continue;
    }

    $page = getFullPage($raw);

    foreach ($page->find('title') as $e) {
        $titles[$path] = $e->innertext;
        echo $e->innertext . PHP_EOL;
    }

    foreach ($page->find('meta[name=description]') as $e) {
        $descriptions[$path] = $e->content;
        echo $e->content . PHP_EOL;
    }

    // $contentNode = getContentNode($raw, '.page-content');
    $contentNode = $page;

    if ($contentNode) {

        foreach ($contentNode->find('*') as $e) {

            if (isset($e->src)) {
                $src = $e->src;
                if ($src == "") {
                    continue;
                }
                if (str_starts_with($src, '/')) {
                    if (str_starts_with($src, '//')){
                        $src = substr($src, 1);
                    }
                    $src = DOMAIN . $src;
                }
                if ($e->srcset) {
                    $e->removeAttribute('srcset');
                }
                $newsrc = saveAsset($src);
                $e->src = $newsrc;
            }
        }

        foreach ($contentNode->find('style') as $styleTag) {
            $styleTag->innertext = processCssImgs($styleTag->innertext);
        }

        // foreach ($contentNode->find('img') as $e) {
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

        foreach ($contentNode->find('source') as $s) {
            $s->outertext = '';
        }
        foreach ($contentNode->find('iframe') as $s) {
            $s->outertext = '';
        }

        foreach ($contentNode->find('div') as $d) {
            if (str_contains($d->style, "background-image:url('")) {
                echo 'finded image in style tag ' . $d->style . PHP_EOL;
                $src = explode("'", $d->style)[1];
                $newsrc = saveAsset($src);
                echo $newsrc . PHP_EOL;
                $d->style = "background-image:url('" . $newsrc . "')";
            }
        }
        foreach ($contentNode->find('a') as $link) {
            $internalLinks[] = $link->href;
        }
        $contentNode->save('temp.html');
        $rendered_html = file_get_contents('temp.html');
        $final_file_content = '<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/header.php"); ?>' . $rendered_html .
'<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/footer.php"); ?>';


$res_link = $readySiteFiles . str_replace('/', '\\', $path);
echo $res_link . PHP_EOL;
if (!is_dir($res_link)) {
mkdir($res_link, 0777, true);
}
file_put_contents($res_link . 'index.php', $final_file_content);
} else {
continue;
}
}
// file_put_contents('internal_links.json', json_encode($internalLinks, JSON_UNESCAPED_UNICODE));
// file_put_contents('titles.json', json_encode($titles, JSON_UNESCAPED_UNICODE));
// file_put_contents('descriptions.json', json_encode($descriptions, JSON_UNESCAPED_UNICODE));