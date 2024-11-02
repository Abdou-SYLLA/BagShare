<?php

require_once '../../database/database.php';

class Account {
    private $conn;

    public function __construct() {
        $dbConnection = new DatabaseConnection();
        $this->conn = $dbConnection->getConnection();
    }

    public function createAccount($numero, $nom, $prenom, $role, $username, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO accounts (numero, nom, prenom, role, username, hashed_password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$numero, $nom, $prenom, $role, $username, $hashed_password]);
        return "Utilisateur ajouté avec succès.";
    }

    public function updateAccount($userId, $nom, $prenom, $role, $username, $password = null) {
        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE accounts SET nom = ?, prenom = ?, role = ?, username = ?, hashed_password = ? WHERE numero = ?");
            $stmt->execute([$nom, $prenom, $role, $username, $hashed_password, $userId]);
        } else {
            $stmt = $this->conn->prepare("UPDATE accounts SET nom = ?, prenom = ?, role = ?, username = ? WHERE numero = ?");
            $stmt->execute([$nom, $prenom, $role, $username, $userId]);
        }
        return "Utilisateur mis à jour avec succès.";
    }

    public function deleteAccount($numero) {
        $stmt = $this->conn->prepare("DELETE FROM accounts WHERE numero = ?");
        return $stmt->execute([$numero]);
    }

    public function getAllAccounts() {
        $stmt = $this->conn->prepare("SELECT numero, nom, prenom, role, username FROM accounts");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserAccount($userId) {
        $stmt = $this->conn->prepare("SELECT nom, prenom, role, username FROM accounts WHERE numero = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour vérifier si un utilisateur est connecté
    public function isAuthenticated() {
        return isset($_SESSION['user']);
    }

    // Méthode pour vérifier si l'utilisateur connecté est un administrateur
    public function isAdmin() {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
    }


    public function __destruct() {
        $this->conn = null; // Fermer la connexion
    }
}
?>
