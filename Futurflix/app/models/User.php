<?php
class User {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    // Registrace nového uživatele se zahašováním hesla
    public function register(
        string $username, 
        string $email, 
        string $password, 
        ?string $firstName = null, 
        ?string $lastName = null, 
        ?string $nickname = null
    ): bool {
        // Kontrola, zda už e-mail neexistuje
        if ($this->findByEmail($email)) {
            return false;
        }

        // BEZPEČNOST: Automatické vytvoření bezpečného hashe (bcrypt)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password, first_name, last_name, nickname) 
                VALUES (:username, :email, :password, :first_name, :last_name, :nickname)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username'   => $username,
            ':email'      => $email,
            ':password'   => $hashedPassword,
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':nickname'   => $nickname
        ]);
    }

    // Najde uživatele podle e-mailu (použijeme pro přihlašování)
    public function findByEmail(string $email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Najde uživatele podle ID (pro zobrazení profilu nebo autora videa)
    public function findById(int $id) {
        $sql = "SELECT id, username, email, first_name, last_name, nickname, created_at FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}