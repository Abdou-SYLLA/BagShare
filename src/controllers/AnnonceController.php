<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../models/Annonce.php';

class AnnonceController {
    public function handleRequest() {
        // Vérifiez ce qui est reçu dans le POST
        var_dump($_POST); // Ajoutez ceci pour voir ce qui est reçu
        if (isset($_POST['action']) && $_POST['action'] === 'getAnnonces') {
            $this->afficherAnnonces();
        } else {
            echo json_encode(['error' => 'Action non reconnue']);
        }
    }

    public function afficherAnnonces() {
        // Instancier le modèle
        $annonceModel = new Annonce();
        
        // Récupérer toutes les annonces
        $annonces = $annonceModel->getAllAnnonces();

        // S'assurer que le type de contenu est bien défini
        header('Content-Type: application/json');

        // Vérification et envoi de la réponse
        if (!empty($annonces)) {
            echo json_encode($annonces);
        } else {
            echo json_encode([]); // Retourner un tableau vide
        }
        exit; // Terminer l'exécution pour éviter toute autre sortie
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AnnonceController();
    $controller->afficherAnnonces();
}

// Exécution de la méthode
$controller = new AnnonceController();
$controller->handleRequest();
