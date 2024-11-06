<?php

class DatabaseConnection {
    private $conn;

    public function __construct() {
        $servername = "mysql-asylla.alwaysdata.net";
        $username = "asylla";
        $password = "Sylla@2024";
        $dbname = "asylla_bagshare";

        try {
            $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
            $this->conn = new PDO($dsn, $username, $password);
            
            // Définir le mode d'erreur de PDO pour lancer des exceptions
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connexion échouée : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn = null; // En PDO, on ferme la connexion en assignant null
    }
}

?>
