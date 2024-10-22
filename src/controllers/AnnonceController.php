<?php

// Activer l'affichage des erreurs
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once '../models/Annonce.php';

class AnnonceController {
    public function handleRequest() {
        // Vérification de l'action envoyée
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'getAnnonces':
                    $this->afficherAnnonces();
                    break;
                case 'create':
                    $this->creerAnnonce();
                    break;
                case 'delete':
                    $this->supprimerAnnonce();
                    break;
                default:
                    echo json_encode(['error' => 'Action non reconnue']);
            }
        } else {
            echo json_encode(['error' => 'Aucune action spécifiée']);
        }
    }

    // Affichage des annonces
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

    // Création d'une annonce
    public function creerAnnonce() {
        session_start(); // Démarrer la session pour obtenir l'utilisateur connecté
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'Utilisateur non connecté']);
            exit;
        }

        // Récupérer les données envoyées
        $annonceData = [
            'description' => $_POST['description'],
            'depart' => $_POST['depart'],
            'arrivee' => $_POST['arrivee'],
            'date' => $_POST['date'],
            'kilos_disponibles' => $_POST['kilos_disponibles'],
            'prix_par_kilo' => $_POST['prix_par_kilo'],
            'user_id' => $_SESSION['user_id'], // L'ID de l'utilisateur connecté
        ];

        $annonceModel = new Annonce();
        $result = $annonceModel->createAnnonce($annonceData);

        if ($result) {
            echo json_encode(['success' => 'Annonce créée avec succès']);
        } else {
            echo json_encode(['error' => "Erreur lors de la création de l'annonce"]);
        }
        exit;
    }

    // Suppression d'une annonce
    public function supprimerAnnonce() {
        session_start(); // Démarrer la session pour obtenir l'utilisateur connecté
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'Utilisateur non connecté']);
            exit;
        }

        // Récupérer l'ID de l'annonce et de l'utilisateur connecté
        $annonceId = $_POST['annonce_id'];
        $userId = $_SESSION['user_id']; // L'ID de l'utilisateur connecté
        $isAdmin = $_SESSION['is_admin'] ?? false; // Vérifier si l'utilisateur est admin

        $annonceModel = new Annonce();
        $result = $annonceModel->deleteAnnonce($annonceId, $userId, $isAdmin);

        if ($result) {
            echo json_encode(['success' => 'Annonce supprimée avec succès']);
        } else {
            echo json_encode(['error' => "Vous n'avez pas l'autorisation de supprimer cette annonce"]);
        }
        exit;
    }
}

// Vérifier si la requête est POST pour traiter les actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AnnonceController();
    $controller->handleRequest();
}
