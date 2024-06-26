<?php



function saveImg($src)
{

    $filename = pathinfo($src, PATHINFO_BASENAME);
    if (str_contains($filename, '%')) {
        $filename = str_replace('%', '_', $filename);
    }

    $realpath = getFilesPath('ready') . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . $filename;
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
    if ($content) {
        $contentStr = $content->save();
        return  str_get_html($contentStr);
        
    } else {
        return null;
    }
}

function getFullPage(string $html): simple_html_dom
{
    $dom = str_get_html($html);
    return $dom;
}


function removeParams(string $str): string
{

    if (strpos($str, "?") !== false) {
        // remove url params
        $str = preg_replace("/\?.*/", "", $str);
        
    }
    $str = str_replace("\u002F",'/', $str);
    $str = str_replace("'",'', $str);
    return $str;
}

function saveAsset($src)
{

    $src = removeParams($src);

    $filename = pathinfo($src, PATHINFO_BASENAME);
    if (str_contains($filename, '%')) {
        $filename = str_replace('%', '_', $filename);
    }

    $realpath = getFilesPath('ready') . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $filename;
    $urlPath = "/assets/$filename";
    echo $urlPath . PHP_EOL;


    file_put_contents($realpath, getHttpContent($src));
    return $urlPath;
}

function saveImgFromCss($src)
{
    $src = $src[0];
    $src = removeParams($src);


    $filename = pathinfo($src, PATHINFO_BASENAME);
    if (str_contains($filename, '%')) {
        $filename = str_replace('%', '_', $filename);
    }


    $urlPath = "/assets/$filename";
    echo $urlPath . PHP_EOL;

    if (str_starts_with($src, '/')) {

        $src = DOMAIN  . $src;
    }
    
     saveAsset($src);
    return "'". $urlPath . "'";
}

function processCssImgs($cssContent)
{
    return preg_replace_callback("/(?<=url\()[^)]*/", 'saveImgFromCss', $cssContent);
}

function processJsImgs($jsContent)
{
    return preg_replace_callback('/(?<=src: ")[^"]*/', 'saveImgFromCss', $jsContent);
}


function normalizeSrcUrl(string $src): string
{


    if ($src == "") {
        exit;
    }
    if (str_starts_with($src, '//')) {

        $src =  str_replace('//', 'https://', $src);
    }
    if (str_starts_with($src, '/')) {

        $src = DOMAIN . $src;
    }
    return $src;
}


function processPageContent(simple_html_dom $dom): simple_html_dom
{
    // universal assets collector
    foreach ($dom->find('*') as $e) {

        if (isset($e->src)) {
            $src = normalizeSrcUrl($e->src);

            if ($e->srcset) {
                $e->removeAttribute('srcset');
            }

            $newsrc = saveAsset($src);
            $e->src = $newsrc;
        }
    }
    foreach ($dom->find('link') as $link) {

        if (isset($link->href)) {
            $src = normalizeSrcUrl($link->href);

            $newsrc = saveAsset($src);
            $link->href = $newsrc;
        }
    }
    foreach ($dom->find('source') as $s) {
        $s->outertext = '';
    }
    foreach ($dom->find('div') as $d) {

        if (str_contains($d->style, "background-image")) {
            echo 'finded image in style tag ' . $d->style . PHP_EOL;
            // preg_match("/\b((https?):\/\/)?([a-z0-9-.]*)\.([a-z]{2,3})([-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$])/i", $d->style, $urls);
            // preg_replace_callback("/\b((https?):\/\/)?([a-z0-9-.]*)\.([a-z]{2,3})([-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$])/i", 'saveImgFromCss', $d->style);
            $d->style = processCssImgs($d->style);

            echo $d->style . PHP_EOL;
        }
    }
    foreach ($dom->find('a') as $link) {
        $internalLinks[] = $link->href;
    }
    foreach ($dom->find('style') as $css) {
        $css->innertext = processCssImgs($css->innertext);
    }
    return $dom;
}
