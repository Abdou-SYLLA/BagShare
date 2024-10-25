<?php
require_once '../../database/database.php'; 

class Account {
    private $conn;

    // Constructeur pour établir la connexion à la base de données
    public function __construct() {
        $dbConnection = new DatabaseConnection();
        $this->conn = $dbConnection->getConnection();
    }

    // Méthode pour créer un nouveau compte
    public function createAccount($user, $username, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Vérifier si l'utilisateur existe déjà dans `users`
        $stmt = $this->conn->prepare("SELECT numero FROM users WHERE numero = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();

        // Insérer l'utilisateur dans `users` s'il n'existe pas
        if ($stmt->num_rows == 0) {
            $stmt->close();
            $stmt = $this->conn->prepare("INSERT INTO users (numero) VALUES (?)");
            $stmt->bind_param("s", $user);
            $stmt->execute();
        }
        $stmt->close();

        // Insérer le compte dans `account`
        $stmt = $this->conn->prepare("INSERT INTO account (user, username, hashed_password) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user, $username, $hashed_password);

        if ($stmt->execute()) {
            return "Compte créé avec succès.";
        } else {
            return "Erreur lors de la création du compte : " . $stmt->error;
        }
        $stmt->close();
    }

    // Méthode pour mettre à jour les informations d'un compte
    public function updateAccount($username, $newPassword, $user) {
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("UPDATE account SET username = ?, hashed_password = ? WHERE user = ?");
        $stmt->bind_param("ssi", $username, $hashed_password, $user);

        if ($stmt->execute()) {
            return "Compte mis à jour avec succès.";
        } else {
            return "Erreur lors de la mise à jour du compte : " . $stmt->error;
        }
        $stmt->close();
    }

    // Méthode pour supprimer un compte
    public function deleteAccount($user) {
        $stmt = $this->conn->prepare("DELETE FROM account WHERE user = ?");
        $stmt->bind_param("i", $user);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }

    // Méthode pour récupérer tous les comptes
    public function getAllAccounts() {
        $query = "SELECT user, username FROM account";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $accounts = [];
        while ($row = $result->fetch_assoc()) {
            $accounts[] = $row;
        }
        $result->free();
        $stmt->close();

        return $accounts;
    }

    // Fermer la connexion lors de la destruction de l'objet
    public function __destruct() {
        $this->conn->close();
    }
}
?>
