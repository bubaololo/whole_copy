<?php
$config = require 'config.php';
function getFilesPath($folder = ''): string
{
    global $config;
    return __DIR__ . DIRECTORY_SEPARATOR . $config['paths']['app_files']. d;
}
echo getFilesPath();