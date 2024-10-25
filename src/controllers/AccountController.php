<?php
session_start();
require_once '../models/Account.php';

class AccountController {
    private $accountModel;

    public function __construct() {
        $this->accountModel = new Account();
    }

    // Action pour créer un compte
    public function createAccount($user, $username, $password) {
        echo $this->accountModel->createAccount($user, $username, $password);
    }

    // Action pour mettre à jour un compte
    public function updateAccount($user, $username, $newPassword) {
        echo $this->accountModel->updateAccount($username, $newPassword, $user);
    }

    // Action pour supprimer un compte
    public function deleteAccount($user) {
        if ($this->accountModel->deleteAccount($user)) {
            echo "Compte supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du compte.";
        }
    }

    // Action pour récupérer tous les comptes
    public function getAllAccounts() {
        $accounts = $this->accountModel->getAllAccounts();
        echo json_encode($accounts);
    }
}

// Vérifier quelle action est appelée depuis la requête
if (isset($_POST['action'])) {
    $controller = new AccountController();

    switch ($_POST['action']) {
        case 'create':
            $controller->createAccount($_POST['user'], $_POST['username'], $_POST['password']);
            break;
        
        case 'update':
            $controller->updateAccount($_POST['user'], $_POST['username'], $_POST['newPassword']);
            break;
        
        case 'delete':
            $controller->deleteAccount($_POST['user']);
            break;

        default:
            echo "Action inconnue.";
            break;
    }
} elseif (isset($_GET['action']) && $_GET['action'] === 'getUserAccounts') {
    $controller = new AccountController();
    $controller->getAllAccounts();
}
?>
