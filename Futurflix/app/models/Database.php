<?php

class Database {
    // Přihlašovací údaje k tvému XAMPP MySQL
    private $host = 'localhost';
    private $db_name = 'futurflix';
    private $username = 'root'; // Výchozí jméno v XAMPPu
    private $password = '';     // V XAMPPu je heslo standardně prázdné
    public $db;

    // Funkce, která se pokusí připojit
    public function getConnection() {
        $this->db = null;
        try {
            // Připojujeme se pomocí moderního a bezpečného PDO
            $this->db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Kritická chyba: Nepodařilo se připojit k databázi: " . $exception->getMessage();
        }
        return $this->db;
    }
}