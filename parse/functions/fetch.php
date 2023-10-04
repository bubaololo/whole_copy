<?php



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
    
    $realpath = $siteDir . "\\img\\$filename";
    $urlPath = "img/$filename";
    
    $options = array(
        'http' => array(
            'method' => "GET",
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3\r\n",
        ),
    );
    
    $context = stream_context_create($options);

    file_put_contents($realpath, file_get_contents($src, false, $context));
    return $urlPath;
}


function getContentNode(string $html, string $node): simple_html_dom
{
    $phpdom = new DOMDocument();
    $phpdom->loadHTML($html);
    $content = $phpdom->getElementById($node);
    $rawcontent =  $phpdom->saveHTML($content);
    return  str_get_html($rawcontent);
   

    
//        return $contentNode;
}