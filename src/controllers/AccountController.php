<?php
session_start();
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../models/Account.php';

// Définir le Content-Type pour JSON
header('Content-Type: application/json');

class AccountController {
    private $accountModel;

    public function __construct() {
        $this->accountModel = new Account();
    }

    // Action pour créer un compte
    public function createAccount($numero, $nom, $prenom, $role, $username, $password) {
        $result = $this->accountModel->createAccount($numero, $nom, $prenom, $role, $username, $password);
        echo json_encode(['message' => $result]);
    }

    // Action pour mettre à jour un compte
    public function updateAccount($numero, $nom, $prenom, $role) {
        $result = $this->accountModel->updateAccount($numero, $nom, $prenom, $role);
        echo json_encode(['message' => $result]);
    }

    // Action pour supprimer un compte
    public function deleteAccount($numero) {
        $result = $this->accountModel->deleteAccount($numero);
        echo json_encode(['message' => $result ? "Utilisateur supprimé avec succès" : "Erreur lors de la suppression"]);
    }

    // Action pour récupérer tous les comptes
    public function getAllAccounts() {
        $accounts = $this->accountModel->getAllAccounts();
        echo json_encode($accounts);
    }

    // Action pour l'authentification
    public function authenticate($username, $password) {
        $isAuthenticated = $this->accountModel->authenticate($username, $password);
        if ($isAuthenticated) {
            echo json_encode(['message' => 'Authentification réussie']);
        } else {
            echo json_encode(['message' => 'Nom d\'utilisateur ou mot de passe incorrect']);
        }
    }

    // Action pour la déconnexion
    public function logout() {
        $this->accountModel->logout();
        echo json_encode(['message' => 'Déconnexion réussie']);
    }

    // Action pour mettre à jour le mot de passe
    public function updatePassword($numero, $oldPassword, $newPassword) {
        $result = $this->accountModel->updatePassword($numero, $oldPassword, $newPassword);
        echo json_encode(['message' => $result]);
    }
}

// Instancier le contrôleur
$controller = new AccountController();

// Traitement des requêtes POST
// Traitement des requêtes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create':
            if (isset($_POST['numero'], $_POST['nom'], $_POST['prenom'], $_POST['role'], $_POST['username'], $_POST['password'])) {
                $controller->createAccount($_POST['numero'], $_POST['nom'], $_POST['prenom'], $_POST['role'], $_POST['username'], $_POST['password']);
            } else {
                echo json_encode(['message' => 'Données manquantes pour la création']);
            }
            break;

        case 'update':
            if (isset($_POST['numero'], $_POST['nom'], $_POST['prenom'], $_POST['role'])) {
                $controller->updateAccount($_POST['numero'], $_POST['nom'], $_POST['prenom'], $_POST['role']);
            } else {
                echo json_encode(['message' => 'Données manquantes pour la mise à jour']);
            }
            break;

        case 'delete':
            if (isset($_POST['numero'])) {
                $controller->deleteAccount($_POST['numero']);
            } else {
                echo json_encode(['message' => 'Numéro de l\'utilisateur manquant pour la suppression']);
            }
            break;

        case 'authenticate':
            if (isset($_POST['username'], $_POST['password'])) {
                $controller->authenticate($_POST['username'], $_POST['password']);
            } else {
                echo json_encode(['message' => 'Nom d\'utilisateur ou mot de passe manquant']);
            }
            break;
        
        case 'getUserAccounts':
            $controller->getAllAccounts();
            break;

        case 'logout':
            $controller->logout();
            break;

        case 'updatePassword':
            if (isset($_POST['numero'], $_POST['oldPassword'], $_POST['newPassword'])) {
                $controller->updatePassword($_POST['numero'], $_POST['oldPassword'], $_POST['newPassword']);
            } else {
                echo json_encode(['message' => 'Données manquantes pour la modification de mot de passe']);
            }
            break;

        default:
            echo json_encode(['message' => 'Action non reconnue']);
            break;
    }
} 


