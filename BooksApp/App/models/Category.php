<?php
class Category {
    private $db;

    // PŘIDAT KONSTRUKTOR:
    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCategories() {
        // Nyní už $this->db nebude null
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}