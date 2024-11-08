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
        if (!isset($_SESSION['user'])) {
            echo json_encode(['error' => 'Utilisateur non connecté']);
            exit;
        }
    
        // Validation des données reçues
        $requiredFields = ['description', 'depart', 'ville_depart', 'arrivee', 'ville_destination', 'adresse_depot', 'date', 'kilos_disponibles', 'prix_par_kilo'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                echo json_encode(['error' => "Le champ $field est requis"]);
                exit;
            }
        }
    
        $annonceData = [
            'description' => htmlspecialchars($_POST['description']),
            'depart' => htmlspecialchars($_POST['depart']),
            'ville_depart' => htmlspecialchars($_POST['ville_depart']),
            'arrivee' => htmlspecialchars($_POST['arrivee']),
            'ville_destination' => htmlspecialchars($_POST['ville_destination']),
            'adresse_depot' => (string)  htmlspecialchars($_POST['adresse_depot']),
            'date' => $_POST['date'],
            'kilos_disponibles' => (int) $_POST['kilos_disponibles'],
            'prix_par_kilo' => (float) $_POST['prix_par_kilo'],
            'numero' => (int) $_POST['numero']  // Correction pour être sûr que numero est bien transmis
        ];
        
    
        // Appel au modèle pour créer l'annonce
        $annonceModel = new Annonce();
        $result = $annonceModel->createAnnonce($annonceData);
    
        // Vérifier le résultat et renvoyer une réponse
        if ($result) {
            echo json_encode(['success' => 'Annonce créée avec succès']);
            header('Location: /src/views/annonce.php');
        } else {
            echo json_encode(['error' => "Erreur lors de la création de l'annonce"]);
            header('Location: /src/views/annonce.php');
        }
        exit;
    }
    

    // Suppression d'une annonce
    public function supprimerAnnonce() {
        session_start(); // Démarrer la session pour obtenir l'utilisateur connecté
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            echo json_encode(['error' => 'Utilisateur non connecté']);
            exit;
        }

        // Récupérer l'ID de l'annonce et de l'utilisateur connecté
        $annonceId = $_POST['id'];
        $userId = $_SESSION['user']['numero']; // L'ID de l'utilisateur connecté
        $isAdmin = $_SESSION['user']['role'] == 'admin'; // Vérifier si l'utilisateur est admin

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
