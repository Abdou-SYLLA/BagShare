<?php

class User {
    private $conn;

    // Constructeur pour établir la connexion à la base de données
    public function __construct() {
        // Informations de connexion (à externaliser idéalement dans un fichier de config)
        $servername = "127.0.0.1";
        $username = "root";
        $password = "12345678";
        $dbname = "bagshare";

        // Connexion à la base de données
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier la connexion
        if ($this->conn->connect_error) {
            throw new Exception("Connexion échouée: " . $this->conn->connect_error);
        }
    }

    // Méthode pour l'authentification de l'utilisateur
    public function authenticate($username, $password) {
        // Préparer et exécuter la requête pour récupérer les informations d'utilisateur
        $stmt = $this->conn->prepare("SELECT hashed_password, role, nom FROM account INNER JOIN users ON (user = numero) WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Si l'utilisateur est trouvé
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $role, $nom);
            $stmt->fetch();

            // Vérifier le mot de passe
            if (password_verify($password, $hashed_password)) {
                // Si authentification réussie, créer la session
                $_SESSION['user'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['nom'] = $nom;

                return true; // Retourner true pour indiquer que l'authentification a réussi
            } else {
                return false; // Mot de passe incorrect
            }
        } else {
            return false; // Aucun utilisateur trouvé
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

    // Fermer la connexion lors de la destruction de l'objet
    public function __destruct() {
        $this->conn->close();
    }
}
