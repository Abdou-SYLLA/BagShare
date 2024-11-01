<?php

require_once '../../database/database.php';

class Account {
    private $conn;

    // Constructeur pour établir la connexion à la base de données
    public function __construct() {
        $dbConnection = new DatabaseConnection();
        $this->conn = $dbConnection->getConnection();
    }

    // Méthode pour créer un nouveau compte utilisateur
    public function createAccount($numero, $nom, $prenom, $role, $username, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO accounts (numero, nom, prenom, role, username, hashed_password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$numero, $nom, $prenom, $role, $username, $hashed_password]);

        return "Utilisateur ajouté avec succès.";
    }

    // Méthode pour authentifier un utilisateur
    public function authenticate($username, $password) {
        $stmt = $this->conn->prepare("SELECT hashed_password, role, nom, prenom, numero FROM accounts WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['hashed_password'];
            $role = $row['role'];
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $numero = $row['numero'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user'] = [
                    'numero' => $numero,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'role' => $role,
                    'username' => $username,
                ];
                return true;
            } else {
                return false; // Mot de passe incorrect
            }
        } else {
            return false; // Utilisateur non trouvé
        }
    }

    // Méthode pour mettre à jour les informations d'un utilisateur
    public function updateAccount($numero, $nom, $prenom, $role) {
        $stmt = $this->conn->prepare("UPDATE accounts SET nom = ?, prenom = ?, role = ? WHERE numero = ?");
        $stmt->execute([$nom, $prenom, $role, $numero]);

        return "Utilisateur mis à jour avec succès.";
    }

    // Méthode pour mettre à jour le mot de passe d'un utilisateur
    public function updatePassword($numero, $oldPassword, $newPassword) {
        $stmt = $this->conn->prepare("SELECT hashed_password FROM accounts WHERE numero = ?");
        $stmt->execute([$numero]);

        if ($stmt->rowCount() > 0) {
            $hashed_password = $stmt->fetchColumn();

            if (password_verify($oldPassword, $hashed_password)) {
                $new_hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $this->conn->prepare("UPDATE accounts SET hashed_password = ? WHERE numero = ?");
                $stmt->execute([$new_hashed_password, $numero]);

                return "Mot de passe modifié avec succès.";
            } else {
                return "Ancien mot de passe incorrect.";
            }
        } else {
            return "Utilisateur non trouvé.";
        }
    }

    // Méthode pour supprimer un utilisateur
    public function deleteAccount($numero) {
        $stmt = $this->conn->prepare("DELETE FROM accounts WHERE numero = ?");
        $stmt->execute([$numero]);

        return "Utilisateur supprimé avec succès.";
    }

    // Méthode pour récupérer tous les utilisateurs
    public function getAllAccounts() {
        $stmt = $this->conn->prepare("SELECT numero, nom, prenom, role, username FROM accounts");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour vérifier si un utilisateur est connecté
    public function isAuthenticated() {
        return isset($_SESSION['user']);
    }

    // Méthode pour vérifier si l'utilisateur connecté est un administrateur
    public function isAdmin() {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
    }

    // Méthode pour déconnecter l'utilisateur
    public function logout() {
        session_unset();
        session_destroy();
    }

    // Fermer la connexion lors de la destruction de l'objet
    public function __destruct() {
        $this->conn = null; // Fermer la connexion
    }
}
?>
