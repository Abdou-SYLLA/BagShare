<?php
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
        
        // Vérifiez que les valeurs sont valides
        if (empty($numero) || empty($nom) || empty($prenom) || empty($role) || empty($username) || empty($hashed_password)) {
            return "Erreur: tous les champs doivent être remplis.";
        }
    
        $stmt = $this->conn->prepare("INSERT INTO accounts (numero, nom, prenom, role, username, hashed_password) VALUES (:numero, :nom, :prenom, :role, :username, :hashed_password)");
        
        $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':hashed_password', $hashed_password, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return "Utilisateur ajouté avec succès.";
            
        } else {
            return "Erreur lors de l'ajout de l'utilisateur : " . $stmt->errorInfo()[2];
        }
    }
    

    // Méthode pour authentifier un utilisateur
    public function authenticate($username, $password) {
        $stmt = $this->conn->prepare("SELECT hashed_password, role, nom, prenom, numero FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['hashed_password'])) {
                $_SESSION['user'] = [
                    'numero' => $user['numero'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'role' => $user['role'],
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

    // Méthode pour mettre à jour le nom d'un utilisateur
    public function editNom($username, $nom) {
        try {
            $sql = "UPDATE accounts SET nom = :nom WHERE username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            return "Nom mis à jour avec succès.";
        } catch (PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }
    

    // Méthode pour mettre à jour le prénom d'un utilisateur
    public function editPrenom($username, $prenom) {
        $stmt = $this->conn->prepare("UPDATE accounts SET prenom = :prenom WHERE username = :username");
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Prénom mis à jour avec succès.";
        } else {
            return "Erreur lors de la mise à jour du prénom : " . $stmt->errorInfo()[2];
        }
    }

    // Méthode pour mettre à jour le rôle d'un utilisateur
    public function editRole($username, $role) {
        $stmt = $this->conn->prepare("UPDATE accounts SET role = :role WHERE username = :username");
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Rôle mis à jour avec succès.";
        } else {
            return "Erreur lors de la mise à jour du rôle : " . $stmt->errorInfo()[2];
        }
    }

    // Méthode pour mettre à jour le mot de passe d'un utilisateur
    public function updatePassword($username, $oldPassword, $newPassword) {
        $stmt = $this->conn->prepare("SELECT hashed_password FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($oldPassword, $user['hashed_password'])) {
                $new_hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                
                $stmt = $this->conn->prepare("UPDATE accounts SET hashed_password = :hashed_password WHERE username = :username");
                $stmt->bindParam(':hashed_password', $new_hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':username', $username, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    return "Mot de passe modifié avec succès.";
                } else {
                    return "Erreur lors de la modification du mot de passe : " . $stmt->errorInfo()[2];
                }
            } else {
                return "Ancien mot de passe incorrect.";
            }
        } else {
            return "Utilisateur non trouvé.";
        }
    }

    //mise à jour par l'admin
    public function updatePasswordByAdmin($username, $newPassword) {
        $stmt = $this->conn->prepare("UPDATE accounts SET hashed_password = :hashed_password WHERE username = :username");
        $stmt->bindParam(':hashed_password', $new_hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Mot de passe modifié avec succès.";
        } else {
            return "Erreur lors de la modification du mot de passe : " . $stmt->errorInfo()[2];
        }
    }

    // Méthode pour récupérer un utilisateur par ID
    public function getUserAccount($userId) {
        $stmt = $this->conn->prepare("SELECT nom, prenom, role, username FROM accounts WHERE numero = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour supprimer un utilisateur
    public function deleteAccount($numero) {
        $stmt = $this->conn->prepare("DELETE FROM accounts WHERE numero = :numero");
        $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Utilisateur supprimé avec succès.";
        } else {
            return "Erreur lors de la suppression de l'utilisateur : " . $stmt->errorInfo()[2];
        }
    }

    // Méthode pour récupérer tous les utilisateurs
    public function getAllAccounts() {
        $query = "SELECT numero, nom, prenom, role, username FROM accounts";
        $stmt = $this->conn->prepare($query);
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
        $this->conn = null; // PDO se ferme automatiquement, mais on peut explicitement la libérer
    }
}
