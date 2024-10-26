<?php


// Activer l'affichage des erreurs pour le développement (à désactiver en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../models/Account.php';

class AuthController {
    private $accountModel;

    public function __construct() {
        $this->accountModel = new Account();
    }

    // Action pour l'authentification
    // Action pour l'authentification
    public function authenticate($username, $password) {
        $isAuthenticated = $this->accountModel->authenticate($username, $password);
        if ($isAuthenticated) {    
            echo json_encode(['message' => 'Authentification réussie']);
            header('Location: /public/index.php');
        } else {
            echo json_encode(['message' => 'Nom d\'utilisateur ou mot de passe incorrect']);
        }
    }

    // Action pour la déconnexion
    public function logout() {
        session_unset(); // Libère toutes les variables de session
        session_destroy(); // Détruit la session
        header('Location: /src/views/connexion.php'); // Redirection après déconnexion
        exit();
    }
}

// Instancier le contrôleur
$controller = new AuthController();

// Traitement des requêtes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'authenticate':
            if (isset($_POST['username'], $_POST['password'])) {
                $controller->authenticate($_POST['username'], $_POST['password']);

            } else {
                header('Location: /src/views/connexion.php?error=missing'); // Redirection si des données sont manquantes
                exit();
            }
            break;

        case 'logout':
            $controller->logout();
            break;

        default:
            header('Location: /src/views/connexion.php?error=action'); // Redirection si l'action n'est pas reconnue
            exit();
            break;
    }
} 
