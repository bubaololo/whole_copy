<?php

require_once '../../bootstrap.php';



$path = '';
echo 'begin process ' . $path . PHP_EOL;
// $fullPath = DOMAIN . $path;
$fullPath = getFilesPath('local') . DIRECTORY_SEPARATOR . 'index.html';
$rawHtml = file_get_contents($fullPath);



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
$rendered_html = file_get_contents('temp.html');
$final_file_content = '<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/header.php"); ?>' . $rendered_html . '<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/footer.php"); ?>';


$res_link = $readySiteFiles . str_replace('/', '\\', $path);
echo $res_link . PHP_EOL;
if (!is_dir($res_link)) {
    mkdir($res_link, 0777, true);
}
file_put_contents('index.php', $rendered_html);


file_put_contents('internal_links.json', json_encode($internalLinks, JSON_UNESCAPED_UNICODE));
