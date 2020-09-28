<?php
require 'Book.php';

class FileHandler
{
    /**
     * Check if valid xml and add root element if invalid
     * @param string $path XML File
     * @return bool
     */
    public function parseXML(string $path): bool
    {
        if (!$this->isValidXml($path)) {
            $xml = '<books>' . file_get_contents($path) . '</books>';
        } else {
            $xml = file_get_contents($path);
        }
        $xml = new SimpleXMLElement($xml);

        foreach ($xml as $item) {
            $book = new Book();
            $book->setAuthor($item->author);
            $book->setName($item->name);
            $book->save();
        }

        return true;
    }

    private function isValidXml(string $file): bool
    {
        libxml_use_internal_errors(TRUE);
        $dom = new DOMDocument();
        $dom->load($file);

        return count(libxml_get_errors()) === 0;
    }
}