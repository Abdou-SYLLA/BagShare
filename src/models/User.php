<?php
class User {
    private $conn;

    // Constructeur pour établir la connexion à la base de données
    public function __construct() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "12345678";
        $dbname = "bagshare";

        // Créer une connexion
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier la connexion
        if ($this->conn->connect_error) {
            die("Connexion échouée: " . $this->conn->connect_error);
        }
    }

    // Méthode pour gérer l'authentification de l'utilisateur
    public function authenticate($username, $password) {
        // Préparer et exécuter la requête pour vérifier les identifiants
        $stmt = $this->conn->prepare("SELECT hashed_password, role, nom FROM account INNER JOIN users ON (user = numero) WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Lier les résultats si un utilisateur est trouvé
            $stmt->bind_result($hashed_password, $role, $nom);
            $stmt->fetch();

            // Vérifier le mot de passe
            if (password_verify($password, $hashed_password)) {
                // Si le mot de passe est valide, enregistrer les informations de session
                $_SESSION['user'] = $username; // Nom d'utilisateur
                $_SESSION['role'] = $role; // Rôle de l'utilisateur
                $_SESSION['nom'] = $nom; // Nom de l'utilisateur

                return true; // Authentification réussie
            } else {
                return "Mot de passe incorrect."; // Mot de passe invalide
            }
        } else {
            return "Nom d'utilisateur introuvable."; // Aucun utilisateur trouvé
        }

        $stmt->close();
    }

    // Méthode pour déconnecter l'utilisateur
    public function logout() {
        session_unset(); // Supprimer toutes les variables de session
        session_destroy(); // Détruire la session
    }

    // Méthode pour vérifier si l'utilisateur est connecté
    public function isAuthenticated() {
        return isset($_SESSION['user']);
    }

    // Méthode pour vérifier si l'utilisateur est un administrateur
    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    // Méthode pour supprimer un utilisateur
    public function deleteUser($username) {
        // Vérifier si l'utilisateur est connecté
        if (!$this->isAuthenticated()) {
            return "Utilisateur non authentifié.";
        }

        // Vérifier si l'utilisateur est l'admin ou l'utilisateur lui-même
        if ($this->isAdmin() || ($_SESSION['user'] === $username)) {
            // Préparer la requête pour supprimer l'utilisateur
            $stmt = $this->conn->prepare("DELETE FROM account WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();

            // Vérifier si la suppression a réussi
            if ($stmt->affected_rows > 0) {
                return "Utilisateur supprimé avec succès.";
            } else {
                return "Erreur lors de la suppression de l'utilisateur ou utilisateur introuvable.";
            }
        } else {
            return "Vous n'avez pas l'autorisation de supprimer cet utilisateur.";
        }
    }

    // Fermer la connexion lorsque l'objet est détruit
    public function __destruct() {
        $this->conn->close();
    }
}
?>
