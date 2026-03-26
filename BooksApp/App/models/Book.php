<?php
// Soubor: App/models/Book.php

require_once 'Database.php';

class Book {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function insert($data) {
        // SQL dotaz s parametry pro ochranu před SQL injection
        $sql = "INSERT INTO books (title, author, category, isbn, year, price, description) 
                VALUES (:title, :author, :category, :isbn, :year, :price, :description)";
        
        $stmt = $this->db->prepare($sql);
        
        // Propojení dat z formuláře s SQL dotazem
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