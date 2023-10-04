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
    
    file_put_contents($realpath, file_get_contents($src));
    return $urlPath;
}

function getContentNode(string $html, string $node): simple_html_dom
{
    $initialDoc = str_get_html($html);
    $contentNode = $initialDoc->find($node)[0];
    
    $phpdom = new DOMDocument();
    
    $newNode = $phpdom->createElement('div');
    $newNode->nodeValue = $contentNode->outertext;
    
    $newNode = $phpdom->importNode($newNode, true);
    
    $phpdom->appendChild($newNode);
    
   $сука  = $phpdom->saveHTML();
    return str_get_html($сука);
//        return $contentNode;
}