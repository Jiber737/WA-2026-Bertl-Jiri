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

        // Získání jedné konkrétní knihy podle jejího ID
    public function getById($id) {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        // Používá se fetch() místo fetchAll(), protože očekáváme maximálně jeden výsledek.
        // Vrátí asociativní pole s daty knihy, nebo false, pokud kniha neexistuje.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Aktualizace existující knihy
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

        // Parametrů je stejné množství jako u create, navíc je pouze :id
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
            ':images'      => $data['images']
        ]);
    }

        // Trvalé smazání knihy z databáze
    public function delete($id) {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        // Vrací true při úspěchu, false při chybě
        return $stmt->execute([':id' => $id]);
    }
    
}