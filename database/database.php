<?php

class DatabaseConnection {
    private $conn;

    public function __construct() {
        $servername = "localhost";
        $username = "bagshare";
        $password = "Sylla@2024";
        $dbname = "bagshare";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connexion échouée: " . $this->conn->connect_error);
        }

        if (!$this->conn->set_charset("utf8")) {
            printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $this->conn->error);
            exit();
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>
