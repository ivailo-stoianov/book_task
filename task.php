<?php
require 'Crawler.php';

if ($argc > 1) {
    $crawler = new Crawler($argv[1]);
    $fileCount = $crawler->scan();

    echo 'Found ' . $fileCount . ' files';
} else {
    echo 'Please provide start path!';
}
