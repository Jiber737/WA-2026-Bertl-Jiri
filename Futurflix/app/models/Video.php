<?php
require_once 'Database.php';

class Video {
    private $db;

    // V konstruktoru ji správně naplníme
    public function __construct($db) {
        $this->db = $db;
    }

    // Získání všech videí (Mřížka)
    public function getAll() {
        $sql = "SELECT * FROM videos ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Získání konkrétního videa podle ID (pro Edit nebo Show)
    public function getById($id) {
        $sql = "SELECT * FROM videos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vytvoření nového videa
    public function create($title, $youtube_url, $description, $genre, $release_year, $age_rating, $image) {
        $sql = "INSERT INTO videos (title, youtube_url, description, genre, release_year, age_rating, image) 
                VALUES (:title, :youtube_url, :description, :genre, :release_year, :age_rating, :image)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':title'        => $title,
            ':youtube_url'  => $youtube_url,
            ':description'  => $description,
            ':genre'        => $genre,
            ':release_year' => $release_year,
            ':age_rating'   => $age_rating,
            ':image'        => $image
        ]);
    }

    // Aktualizace existujícího videa (Update)
    public function update($id, $title, $youtube_url, $description, $genre, $release_year, $age_rating, $image) {
        $sql = "UPDATE videos 
                SET title = :title, 
                    youtube_url = :youtube_url, 
                    description = :description, 
                    genre = :genre, 
                    release_year = :release_year, 
                    age_rating = :age_rating, 
                    image = :image 
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':id'           => $id,
            ':title'        => $title,
            ':youtube_url'  => $youtube_url,
            ':description'  => $description,
            ':genre'        => $genre,
            ':release_year' => $release_year,
            ':age_rating'   => $age_rating,
            ':image'        => $image
        ]);
    }

    // Smazání videa (Delete)
    public function delete($id) {
        $sql = "DELETE FROM videos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}