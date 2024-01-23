<?php

require_once '../../bootstrap.php';
$jsonFile = getFilesPath('local'. DIRECTORY_SEPARATOR. 'json.json');


    $jsString = file_get_contents($jsonFile);
    $jsString = html_entity_decode($jsString);
    $processedJS = processCssImgs($jsString);
    file_put_contents($jsonFile, $processedJS);


echo "Success! ";




 




