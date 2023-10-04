<?php
set_time_limit(0);
include "simple_html_dom.php";
$currentDir = __DIR__;

// Переходим на уровень выше
$parentDir = dirname($currentDir);

// Добавляем "site" к пути
 $siteDir = $parentDir . DIRECTORY_SEPARATOR . 'site';

$paths = [
    "/",
    "/how-to-play-poker/",
    "/how-to-play-poker/strategy/",
    "/how-to-play-poker/rules/",
    "/how-to-play-poker/hands/",
    "/poker-software/",
    "/platforms/",
    "/poker-software/limits-and-rake/",
    "/poker-games/",
    "/poker-games/texas-holdem/",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/poker-games/blast-game/",
    "/poker-games/snap/",
    "/poker-promotions/",
    "/poker-promotions/bonus/",
    "/poker-promotions/bonus/no-deposit-8/",
    "/poker-promotions/24-7-freerolls-festival/",
    "/poker-promotions/invite-a-friend/iaf/",
    "/888poker-club/",
    "/real-money-poker/deposit/",
    "/real-money-poker/",
    "/real-money-poker/deposit/",
    "/real-money-poker/cashout/",
    "/real-money-poker/deposit/payment-methods/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/poker-tournaments/",
    "/poker-tournaments/types/",
    "/poker-tournaments/types/multi-table-tournament/",
    "/poker-games/pko/",
    "/poker-tournaments/mystery-bounty/",
    "/888live-events/",
    "/the-team/",
    "/magazine/",
    "/magazine/strategy",
    "/magazine/poker-world",
    "/magazine/888news",
    "/poker/poker-odds-calculator/"
];

foreach($paths as $path) {
    echo 'begin process ' . $path . PHP_EOL;
$fullPath = $siteDir. str_replace('/','\\',$path)."index.html";

if (($raw = @file_get_contents($fullPath)) === false) {
    $error = error_get_last();
    echo "HTTP request failed. Error was: " . $error['message'].PHP_EOL;
    continue;
} 

libxml_use_internal_errors(TRUE);
$rawHtml = str_get_html($raw);
$contentHtml = $rawHtml->find('.root');


foreach($contentHtml->find('img') as $e){
    $src = $e->src;
    echo 'finded img '. $src.PHP_EOL;
    if($src==""){
        break;
    }
    if(str_starts_with($src,'//')){
        
        $src = str_replace('//','https://',$src);
    }
    if(str_starts_with($src,'/')){
        
        $src = $path.$src;
    }
    if ($e->srcset) {
        $e->removeAttribute('srcset');
    }
    $newsrc = saveImg($src);
    $e->src = $newsrc;

}

foreach ($contentHtml->find('div') as $d) {
    if (str_contains($d->style, "background-image:url('")) {
        echo 'finded image in style tag ' . $d->style . PHP_EOL;
        $src = explode("'", $d->style)[1];
        if(filter_var($src, FILTER_VALIDATE_URL)){
        $newsrc = saveImg($src);
        echo $newsrc . PHP_EOL;
        $d->style = "background-image:url('" . $newsrc . "')";
        } else { continue; }
    }
}

$contentHtml->save('yo.html');
$rendered_html = file_get_contents('yo.html');
$final_file_content = '<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/header.php"); ?>'.$rendered_html.'<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/footer.php"); ?>';

    $link = substr($path, 1);
    $res_link=$link.'/';
    echo $res_link.PHP_EOL;
    if(!is_dir($res_link)) {
    mkdir($res_link, 0777, true);
}
file_put_contents($res_link.'/index.php', $final_file_content);

}



function saveImg($src)
{
    global $siteDir;
    $filename = pathinfo($src, PATHINFO_BASENAME);
    if (str_contains($filename, '%')) {
        $filename = str_replace('%', '_', $filename);
    }
    // if (in_array($filename, $all_filenames)) {
    //     $filename = uniqid() . $filename;
    // };

    $realpath = $siteDir."\\img\\$filename";
    $urlPath = "img/$filename";

    file_put_contents($realpath, file_get_contents($src));
    return $urlPath;
}
