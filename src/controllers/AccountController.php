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

    public function updateAccount($userId, $nom, $prenom, $role, $username, $password = null) {
        $result = $this->accountModel->updateAccount($userId, $nom, $prenom, $role, $username, $password);
        echo json_encode(['message' => $result]);
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
            break;

        case 'updateAccount':
            $controller->updateAccount($_POST['userId'], $_POST['nom'], $_POST['prenom'], $_POST['role'], $_POST['username'], $_POST['password']);
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
