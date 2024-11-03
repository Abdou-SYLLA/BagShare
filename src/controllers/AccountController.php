<?php
session_start();

require_once '../models/Account.php';

header('Content-Type: application/json');

class AccountController {
    private $accountModel;

    public function __construct() {
        $this->accountModel = new Account();
    }

    public function createAccount($numero, $nom, $prenom, $role, $username, $password) {
        $result = $this->accountModel->createAccount($numero, $nom, $prenom, $role, $username, $password);
        echo json_encode(['message' => $result]);
    }

    public function updateAccount($username, $nom = null, $prenom = null, $role = null, $newPassword = null) {
        $response = [];
        if (!empty($nom)) {
            $response['nom'] = $this->accountModel->editNom($username, $nom);
        }
        if (!empty($prenom)) {
            $response['prenom'] = $this->accountModel->editPrenom($username, $prenom);
        }
        if (!empty($role)) {
            $response['role'] = $this->accountModel->editRole($username, $role);
        }
        if (!empty($newPassword)) {
            $response['password'] = $this->accountModel->editPassword($username, $newPassword);
        }
        
        echo json_encode(['message' => $response ? $response : "Aucune modification effectuée."]);
    }
    
    
    

    public function deleteAccount($numero) {
        $result = $this->accountModel->deleteAccount($numero);
        echo json_encode(['message' => $result ? "Utilisateur supprimé avec succès" : "Erreur lors de la suppression"]);
    }

    public function getAllAccounts() {
        $accounts = $this->accountModel->getAllAccounts();
        echo json_encode($accounts);
    }

    public function getUserAccount($userId) {
        $account = $this->accountModel->getUserAccount($userId);
        echo json_encode($account);
    }
}

$controller = new AccountController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create':
            $controller->createAccount($_POST['numero'], $_POST['nom'], $_POST['prenom'], $_POST['role'], $_POST['username'], $_POST['password']);
            header('Location: ../views/account.php');
            break;

        case 'updateAccount':
            // Extraire les informations pertinentes du formulaire
            $nom = $_POST['editNom'] ?? null;
            $prenom = $_POST['editPrenom'] ?? null;
            $role = $_POST['editRole'] ?? null;
            $newPassword = $_POST['editPassword'] ?? null; 

            $controller->updateAccount($_POST['editUsername'], $nom, $prenom, $role, $newPassword);
            break;

        case 'delete':
            $controller->deleteAccount($_POST['numero']);
            break;

        case 'getUser':
            $controller->getUserAccount($_POST['userId']);
            break;

        case 'getUserAccounts':
            $controller->getAllAccounts();
            break;

        default:
            echo json_encode(['message' => 'Action non reconnue']);
            break;
    }
}

?>
