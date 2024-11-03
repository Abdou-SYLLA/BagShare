<?php
session_start();
require_once '../models/Account.php';

class AuthController {
    private $accountModel;

    public function __construct() {
        $this->accountModel = new Account();
    }

    // Action pour l'authentification
    public function authenticate($username, $password) {
        $isAuthenticated = $this->accountModel->authenticate($username, $password);
        if ($isAuthenticated) {    
            //echo json_encode(['message' => 'Authentification réussie']);
            header('Location: /public/index.php');
        } else {
            //echo json_encode(['message' => 'Nom d\'utilisateur ou mot de passe incorrect']);
            header('Location: /src/views/connexion.php?error=Nom d\'utilisateur ou mot de passe incorrect');
            exit();
        }
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
                header('Location: /src/views/connexion.php?error=Veuillez remplir tous les champs'); // Redirection si des données sont manquantes
                exit();
            }
            break;

        default:
            header('Location: /src/views/connexion.php?error=Action non reconnue'); // Redirection si l'action n'est pas reconnue
            exit();
            break;
    }
} 
