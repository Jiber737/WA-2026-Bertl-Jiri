<?php
class Comment {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Získání všech komentářů pro konkrétní video (včetně jména autora)
    public function getByVideoId(int $videoId) {
        $sql = "SELECT comments.*, users.username, users.nickname 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE video_id = :video_id 
                ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':video_id' => $videoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Načtení jednoho komentáře (potřebujeme pro kontrolu práv před smazáním)
    public function getById(int $id) {
        $sql = "SELECT * FROM comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Přidání nového komentáře
    public function create(int $videoId, int $userId, string $content) {
        $sql = "INSERT INTO comments (video_id, user_id, content) VALUES (:video_id, :user_id, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':video_id' => $videoId,
            ':user_id'  => $userId,
            ':content'  => $content
        ]);
    }

    // Smazání komentáře
    public function delete(int $id) {
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}