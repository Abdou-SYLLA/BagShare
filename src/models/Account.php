<?php

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

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
        $stmt->bind_param("isssss", $numero, $nom, $prenom, $role, $username, $hashed_password);

        if ($stmt->execute()) {
            return "Utilisateur ajouté avec succès.";
        } else {
            return "Erreur lors de l'ajout de l'utilisateur : " . $stmt->error;
        }

        $stmt->close();
    }

    // Méthode pour authentifier un utilisateur
    public function authenticate($username, $password) {
        $stmt = $this->conn->prepare("SELECT hashed_password, role, nom, prenom, numero FROM accounts WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $role, $nom, $prenom, $numero);
            $stmt->fetch();

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

        $stmt->close();
    }

    // Méthode pour mettre à jour les informations d'un utilisateur
    public function updateAccount($numero, $nom, $prenom, $role) {
        $stmt = $this->conn->prepare("UPDATE accounts SET nom = ?, prenom = ?, role = ? WHERE numero = ?");
        $stmt->bind_param("sssi", $nom, $prenom, $role, $numero);

        if ($stmt->execute()) {
            return "Utilisateur mis à jour avec succès.";
        } else {
            return "Erreur lors de la mise à jour de l'utilisateur : " . $stmt->error;
        }

        $stmt->close();
    }

    // Méthode pour mettre à jour le mot de passe d'un utilisateur
    public function updatePassword($numero, $oldPassword, $newPassword) {
        $stmt = $this->conn->prepare("SELECT hashed_password FROM accounts WHERE numero = ?");
        $stmt->bind_param("i", $numero);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($oldPassword, $hashed_password)) {
                $stmt->close();
                
                $new_hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $this->conn->prepare("UPDATE accounts SET hashed_password = ? WHERE numero = ?");
                $stmt->bind_param("si", $new_hashed_password, $numero);

                if ($stmt->execute()) {
                    return "Mot de passe modifié avec succès.";
                } else {
                    return "Erreur lors de la modification du mot de passe : " . $stmt->error;
                }
            } else {
                return "Ancien mot de passe incorrect.";
            }
        } else {
            return "Utilisateur non trouvé.";
        }

        $stmt->close();
    }

    // Méthode pour supprimer un utilisateur
    public function deleteAccount($numero) {
        $stmt = $this->conn->prepare("DELETE FROM accounts WHERE numero = ?");
        $stmt->bind_param("i", $numero);

        if ($stmt->execute()) {
            return "Utilisateur supprimé avec succès.";
        } else {
            return "Erreur lors de la suppression de l'utilisateur : " . $stmt->error;
        }

        $stmt->close();
    }

    // Méthode pour récupérer tous les utilisateurs
    public function getAllAccounts() {
        $query = "SELECT numero, nom, prenom, role, username FROM accounts";
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
        $this->conn->close();
    }
}
