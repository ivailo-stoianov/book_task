<?php

require 'FileHandler.php';

class Crawler
{
    private string $startDir;
    private FileHandler $fileHandler;

    public function __construct(string $startDir)
    {
        $this->startDir = $startDir;
        $this->fileHandler = new FileHandler();
    }

    public function scan(): int
    {
        $count = 0;
        $items = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->startDir, FilesystemIterator::SKIP_DOTS)
        );

        foreach ($items as $item) {
            if ($item->getExtension() === 'xml') {
                $this->fileHandler->parseXML($item->getPathName());
                echo 'Found file: ' . $item->getBasename() . PHP_EOL;
                $count++;
            }
        }

        return $count;
    }
}
