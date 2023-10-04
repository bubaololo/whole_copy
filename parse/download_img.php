<?php
set_time_limit(0);
include "simple_html_dom.php";
$url='https://play.pokerok900.com/';
$raw = file_get_contents($url);
libxml_use_internal_errors(TRUE);
$phpdom = new DOMDocument();
$phpdom->loadHTML($raw);
$content = $phpdom->getElementById('content');
$rawcontent =  $phpdom->saveHTML($content);
$html = str_get_html($rawcontent);

foreach($html->find('img') as $e){
    $src = $e->src;
    if (str_contains($src,'yandex')){
        $e->src = '';
        continue;
    }
    if(str_starts_with($src,'//')){
        
        $src = str_replace('//','https://',$src);
    }
    if(str_starts_with($src,'/')){
        
        $src = $url.$src;
    }

$all_filenames = scandir('img');
$filename = pathinfo($src,PATHINFO_BASENAME);
if (str_contains($filename,'%')){
    $filename = str_replace('%','_',$filename);
}
if(in_array($filename,$all_filenames)){
    $filename=uniqid().$filename;
};

    $newpath = "img\\$filename";
    $e->src = $newpath;
    file_put_contents($newpath,file_get_contents($src));
    
    echo $newpath.PHP_EOL;
    // echo "<br>";
}
$html->save('yo.html');
$rendered_html = file_get_contents('yo.html');
$final_file_content = '<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/header.php"); ?>'.$rendered_html.'<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/footer.php"); ?>';
file_put_contents('index.php',$final_file_content);


