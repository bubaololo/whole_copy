<?php

require_once '../../bootstrap.php';

$assetsDir = getFilesPath('ready'. DIRECTORY_SEPARATOR. 'assets');

$cssFiles = glob($assetsDir . '\*.css');
foreach($cssFiles as $file)
{
    $cssString = file_get_contents($file);
    $processedCss = processCssImgs($cssString);
    file_put_contents($file, $processedCss);
}

echo "Success! ".count($cssFiles)." processed";




 




