<?php

require_once 'Database.php';

class Book {
    private $conn;
    private $table_name = "books"; // Ujisti se, že se takto jmenuje tvá tabulka v DB

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Metoda pro uložení nové knihy
    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (title, author, category, isbn, year, price, description) 
                  VALUES (:title, :author, :category, :isbn, :year, :price, :description)";

        $stmt = $this->conn->prepare($query);

        // Vyčištění a nabindování dat
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':author', $data['author']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':isbn', $data['isbn']);
        $stmt->bindParam(':year', $data['year']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':description', $data['description']);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}