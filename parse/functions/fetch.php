<?php



function saveImg($src)
{
    global $sourceSiteDir;
    global $readySiteFiles;
    $filename = pathinfo($src, PATHINFO_BASENAME);
    if (str_contains($filename, '%')) {
        $filename = str_replace('%', '_', $filename);
    }
    // if (in_array($filename, $all_filenames)) {
    //     $filename = uniqid() . $filename;
    // };

    $realpath = $readySiteFiles . "\\assets\\$filename";
    $urlPath = "/assets/$filename";
    echo $urlPath . PHP_EOL;
    $options = array(
        'http' => array(
            'method' => "GET",
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3\r\n",
        ),
    );

    $context = stream_context_create($options);

    file_put_contents($realpath, @file_get_contents($src, false, $context));
    return $urlPath;
}


function getContentNode(string $html, string $node): simple_html_dom | null
{
    $initialHtml = str_get_html($html);
    $content = $initialHtml->find($node)[0];
    if($content) {
        $contentStr = $content->save();
        $rawcontent =  str_get_html($contentStr);
        return  str_get_html($rawcontent);
    } else {
        return null;
    }

}
function getFullPage(string $html): simple_html_dom
{
        return  str_get_html($html);
}


function saveAsset($src)
{
    global $sourceSiteDir;
    global $readySiteFiles;

    if (strpos($src, "?") !== false) {
        return preg_replace("/\?.*/", "", $src);
    }



    $filename = pathinfo($src, PATHINFO_BASENAME);
    if (str_contains($filename, '%')) {
        $filename = str_replace('%', '_', $filename);
    }
    // if (in_array($filename, $all_filenames)) {
    //     $filename = uniqid() . $filename;
    // };

    $realpath = $readySiteFiles . "\\assets\\$filename";
    $urlPath = "/assets/$filename";
    echo $urlPath . PHP_EOL;
    $options = array(
        'http' => array(
            'method' => "GET",
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3\r\n",
        ),
    );

    $context = stream_context_create($options);

    file_put_contents($realpath, @file_get_contents($src, false, $context));
    return $urlPath;
}