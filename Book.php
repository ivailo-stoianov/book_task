<?php
require 'Database.php';

class Book
{
    protected string $author;
    protected string $name;
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Updates if there is a record with the same name and author otherwise creates new one
     * @return bool
     */
    public function save()
    {
        $exists = $this->exists();
        if ($exists) {
            return $this->update($exists);
        } else {
            return $this->create();
        }
    }

    /**
     * Checks if book with same author and name exists
     * @return bool|int Returns false if doesn't exists else returns id of record
     */
    private function exists()
    {
        $query = $this->db->prepare(
            'SELECT books.id FROM books WHERE books.author ILIKE :author AND books.name ILIKE :name'
        );

        $query->execute([
            ':author' => '%' . $this->author . '%',
            ':name' => '%' . $this->name . '%'
        ]);
        $result = $query->fetch();

        if ($result) {
            return $result['id'];
        }

        return false;
    }

    /**
     * Updates record
     * @param int $id Id of the record to update
     * @return bool
     */
    private function update(int $id): bool
    {
        $query = $this->db->prepare(
            'UPDATE books SET books.author = :author, books.name = :name WHERE books.id = :id'
        );
        $query->execute([
            ':author' => $this->author,
            ':name' => $this->name,
            ':id' => $id
        ]);

        return $query->rowCount() > 0;
    }

    /**
     * Creates new records
     * @return bool
     */
    public function create(): bool
    {
        $query = $this->db->prepare(
            'INSERT INTO books(author, name) VALUES (:author, :name)'
        );
        $query->execute([
            ':author' => $this->author,
            ':name' => $this->name
        ]);

        return $this->db->lastInsertId('books_id_seq') > 0;
    }

    /**
     * Finds all records with the given author name
     * @param string $author
     * @return array
     */
    public function findByAuthor(string $author): array
    {
        $query = $this->db->prepare(
            'SELECT * FROM books WHERE books.author ILIKE :author'
        );

        $query->execute([
            ':author' => '%' . $author . '%',
        ]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}