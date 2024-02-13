<?php

require_once '../../bootstrap.php';
$jsonFile = getFilesPath('local'. DIRECTORY_SEPARATOR. 'json.json');


    $jsString = file_get_contents($jsonFile);
    $processedJs = processJsImgs($jsString);
    file_put_contents($jsonFile, $processedJs);


echo "Success! ";




 




