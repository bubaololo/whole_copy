<?php
set_time_limit(0);
libxml_use_internal_errors(true);
$config = require_once 'config.php';
$siteFiles = getFilesPath();
$appPath = getAppPath();
require_once getAppPath('functions').DIRECTORY_SEPARATOR . "fetchContent.php";
require_once getAppPath('functions').DIRECTORY_SEPARATOR . "handleFiles.php";
require_once getAppPath('functions' . DIRECTORY_SEPARATOR . 'simplehtmldom_1_9_1').DIRECTORY_SEPARATOR . "simple_html_dom.php";
const DOMAIN = 'https://wptglobal.com/';
libxml_use_internal_errors(true);

function getFilesPath($folder = ''): string
{
    global $config;
    return __DIR__ . DIRECTORY_SEPARATOR . $config['paths']['site_files']. DIRECTORY_SEPARATOR . $folder;
}
function getAppPath($folder = ''): string
{
    global $config;
    return __DIR__ . DIRECTORY_SEPARATOR . $config['paths']['app_files']. DIRECTORY_SEPARATOR . $folder;
}

