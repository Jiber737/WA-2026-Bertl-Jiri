<?php
// Soubor: BooksApp/App/models/Book.php

require_once 'Database.php';

class Book {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAll() {
    $sql = "SELECT * FROM books ORDER BY id DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function create($data) {
        // SQL dotaz pro vložení dat
        $sql = "INSERT INTO books (title, author, category, isbn, year, price, description) 
                VALUES (:title, :author, :category, :isbn, :year, :price, :description)";
        
        $stmt = $this->db->prepare($sql);
        
        // Mapování dat z formuláře na parametry dotazu
        return $stmt->execute([
            ':title'       => $data['title'],
            ':author'      => $data['author'],
            ':category'    => $data['category'],
            ':isbn'        => $data['isbn'],
            ':year'        => $data['year'],
            ':price'       => $data['price'],
            ':description' => $data['description']
        ]);
    }
}