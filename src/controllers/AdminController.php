<?php

class AdminController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    // Afficher la page d'administration
    public function index() {
        $users = $this->userModel->getUsers();
        $ads = $this->userModel->getAds();
        require_once 'views/admin.php';
    }

    // Ajouter un utilisateur
    public function addUser($username, $password, $nom) {
        if ($this->userModel->addUser($username, $password, $nom)) {
            $_SESSION['message'] = "Utilisateur ajouté avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de l'ajout de l'utilisateur.";
        }
        header('Location: admin.php');
    }

    // Supprimer un utilisateur
    public function deleteUser($user_id) {
        if ($this->userModel->deleteUser($user_id)) {
            $_SESSION['message'] = "Utilisateur supprimé avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de l'utilisateur.";
        }
        header('Location: admin.php');
    }

    // Supprimer une annonce
    public function deleteAd($ad_id) {
        if ($this->userModel->deleteAd($ad_id)) {
            $_SESSION['message'] = "Annonce supprimée avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de l'annonce.";
        }
        header('Location: admin.php');
    }
}
?>
