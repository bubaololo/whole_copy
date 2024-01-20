<?php

set_time_limit(0);
include "simple_html_dom.php";
$url='https://play.pokerok920.com/promotions/drops-wins-slots';
$domain='https://play.pokerok900.com';

$links = json_decode(file_get_contents('links.json'), true);


$styles = [];
foreach ($links as $link) {
    $url = $domain.$link;
    try {
        $raw = file_get_contents($url);
    } catch (Exception $e) {
        echo $url." не открылся";
        continue;
    }
    
    libxml_use_internal_errors(true);
    $phpdom = new DOMDocument();
    $phpdom->loadHTML($raw);
    $content = $phpdom->getElementById('content');
    $rawcontent =  $phpdom->saveHTML($content);
    $html = str_get_html($rawcontent);

    foreach ($html->find('div') as $d) {
        if (str_contains($d->style,'background-image') ) {
            $styles[] = $d->style;
            echo $d->style.PHP_EOL;
            $src = explode("'", $d->style)[1];
            $newsrc = saveImg($src);
            echo $newsrc.PHP_EOL;
            $d->style = "background-image:url('".$newsrc."')";
        }
    }
}
var_dump($styles);


function saveImg($src) {
    $all_filenames = scandir('img');
$filename = pathinfo($src,PATHINFO_BASENAME);
if (str_contains($filename,'%')){
    $filename = str_replace('%','_',$filename);
}
if(in_array($filename,$all_filenames)){
    $filename=uniqid().$filename;
};

    $realpath = "img\\$filename";
    $urlPath = "/img/$filename";
    
    file_put_contents($realpath,file_get_contents($src));
    return $urlPath;
}
