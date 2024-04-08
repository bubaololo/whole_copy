<?php

require_once '../../bootstrap.php';

function generateSitemap($urlList) {
    $xmlString = '<?xml version="1.0" encoding="UTF-8"?>
      <urlset
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($urlList as $key => $url) {
      $xmlString .=  '<url><loc>'.$url.'</loc></url>';
    }
    $xmlString .= '</urlset>';
    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = false;
    $dom->loadXML($xmlString);
    $dom->save(getFilesPath('local').'sitemap.xml');
    echo "sitemap.xml generated";
  }


generateSitemap($urls);

