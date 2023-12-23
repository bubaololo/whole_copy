<?php

set_time_limit(0);
include "functions" . DIRECTORY_SEPARATOR . "fetch.php";
const DOMAIN = 'https://www.888poker.com';
$currentDir = __DIR__;

// Переходим на уровень выше
$parentDir = dirname($currentDir);

$readySiteFiles = $parentDir . DIRECTORY_SEPARATOR . 'ready';

$cssFile = 'styles.css';
$cssString = file_get_contents($cssFile);
$options = array(
    'http' => array(
        'method' => "GET",
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3\r\n",
    ),
);
$path = '/';
$context = stream_context_create($options);

$convertedCss = processCssImgs($cssString);
file_put_contents($cssFile,$convertedCss);




 




