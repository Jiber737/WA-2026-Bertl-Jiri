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

    // 1. OPRAVA V CREATE: Přidáno subcategory a images do SQL i pole
    public function create($data) {
        $sql = "INSERT INTO books (title, author, category, subcategory, isbn, year, price, description, images) 
                VALUES (:title, :author, :category, :subcategory, :isbn, :year, :price, :description, :images)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':title'       => $data['title'],
            ':author'      => $data['author'],
            ':category'    => $data['category'],
            ':subcategory' => $data['subcategory'] ?? null,
            ':isbn'        => $data['isbn'],
            ':year'        => $data['year'],
            ':price'       => $data['price'],
            ':description' => $data['description'],
            ':images'      => $data['images'] // Tady předáváme náš JSON s názvy obrázků
        ]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 2. OPRAVA V UPDATE: Opravena proměnná u images
    public function update(
        $id, $title, $author, $category, $subcategory, 
        $year, $price, $isbn, $description, $link, $images = []
    ) {
        $sql = "UPDATE books 
                SET title = :title, 
                    author = :author, 
                    category = :category, 
                    subcategory = :subcategory, 
                    year = :year, 
                    price = :price, 
                    isbn = :isbn, 
                    description = :description, 
                    link = :link, 
                    images = :images
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':subcategory' => $subcategory ?: null,
            ':year' => $year,
            ':price' => $price,
            ':isbn' => $isbn,
            ':description' => $description,
            ':link' => $link,
            ':images' => json_encode($images) // TADY BYL CHYBNÝ ZÁPIS $data['images']
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}