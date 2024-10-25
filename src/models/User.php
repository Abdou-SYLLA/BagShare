<?php
require_once '../../database/database.php'; 
class User {
    private $conn;

    // Constructeur pour établir la connexion à la base de données
    public function __construct() {
        $dbConnection = new DatabaseConnection();
        $this->conn = $dbConnection->getConnection();
    }

    public function authenticate($username, $password) {
        // Préparer et exécuter la requête pour récupérer les informations d'utilisateur
        $req = "SELECT hashed_password, role, nom FROM account 
                INNER JOIN users ON (user = numero) WHERE username = ?";
        $stmt = $this->conn->prepare($req);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
    
        // Si l'utilisateur est trouvé
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $role, $nom);
            $stmt->fetch();
    
            // Vérifier si le mot de passe correspond au hachage
            if (password_verify($password, $hashed_password)) {
                // Si authentification réussie, créer la session
                $_SESSION['user'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['nom'] = $nom;
    
                return true; // Authentification réussie
            } else {
                // Si le mot de passe est incorrect
                return false;
            }
        } else {
            // Si aucun utilisateur trouvé
            return false;
        }
    
        $stmt->close();
    }
    

    // Méthode pour déconnecter l'utilisateur
    public function logout() {
        session_unset();
        session_destroy();
    }

    // Vérifie si un utilisateur est connecté
    public function isAuthenticated() {
        return isset($_SESSION['user']);
    }

    // Vérifie si l'utilisateur est un administrateur
    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    // Supprimer un utilisateur
    public function deleteUser($username) {
        if ($this->isAdmin() || ($_SESSION['user'] === $username)) {
            $stmt = $this->conn->prepare("DELETE FROM account WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();

            return $stmt->affected_rows > 0;
        } else {
            return false; // L'utilisateur n'a pas l'autorisation
        }
    }

    // Création d'un utilisateur
    public function createUser($user, $username, $password) {
        // Hachage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Étape 1 : Vérifier si l'utilisateur existe dans `users`
        $stmt = $this->conn->prepare("SELECT numero FROM users WHERE numero = ?");
        $stmt->bind_param("s", $user); // Utiliser 's' si 'user' est une chaîne
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // L'utilisateur n'existe pas, insérer dans `users`
            $stmt->close();
            $stmt = $this->conn->prepare("INSERT INTO users (numero) VALUES (?)");
            $stmt->bind_param("s", $user);
            $stmt->execute();
        }

        $stmt->close();

        // Étape 2 : Insérer les informations de l'utilisateur dans `account`
        $stmt = $this->conn->prepare("INSERT INTO account (user, username, hashed_password) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user, $username, $hashed_password); // Utilisation des bons types

        if ($stmt->execute()) {
            return "Utilisateur ajouté avec succès.";
        } else {
            return "Erreur lors de l'ajout de l'utilisateur: " . $stmt->error;
        }

        $stmt->close();
    }

     // Méthode pour modifier les informations d'un utilisateur en utilisant le numéro comme clé primaire
    public function updateUser($nom, $prenom, $role, $numero) {
        // Préparer la requête SQL pour mettre à jour les informations de l'utilisateur
        $sql = "UPDATE users SET nom = ?, prenom = ?, role = ? WHERE numero = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            return "Erreur lors de la préparation de la requête : " . $this->conn->error;
        }

        // Lier les paramètres (nom, prénom, rôle, numero)
        $stmt->bind_param("ssss", $nom, $prenom, $role, $numero);

        // Exécuter la requête
        if ($stmt->execute()) {
            return "Utilisateur modifié avec succès.";
        } else {
            return "Erreur lors de la modification de l'utilisateur : " . $stmt->error;
        }

        $stmt->close();
    }
    
    public function getAllUsers() {
        // Requête SQL pour récupérer tous les utilisateurs
        $query = "SELECT nom, prenom, role, numero FROM users ";
    
        // Préparer la requête
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->execute();

            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $users = [];
    
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row;
                }
                $result->free();

                return $users;
            } else {
                // Aucun utilisateur trouvé
                return [];
            }
    
            $stmt->close();
        } else {
            return [];
        }
    }
    
    // Fermer la connexion lors de la destruction de l'objet
    public function __destruct() {
        $this->conn->close();
    }
}
