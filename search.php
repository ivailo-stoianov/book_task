<?php
require 'Book.php';

$author = $_POST['author'];
$book = new Book();
$books = $book->findByAuthor(htmlspecialchars($author));

echo json_encode($books);