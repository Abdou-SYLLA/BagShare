<?php
session_start();
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../database/database.php'; // Assurez-vous que le chemin d'importation est correct

// Définir le Content-Type pour JSON
header('Content-Type: application/json');

class AvantageController {
    private $conn;

    public function __construct() {
        $dbConnection = new DatabaseConnection();
        $this->conn = $dbConnection->getConnection();
    }

    // Méthode pour récupérer tous les avantages
    public function getAllAvantages() {
        $query = $this->conn->prepare("SELECT texte FROM avantages");
        $query->execute();
        
        // Récupérer tous les résultats sous forme de tableau associatif
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // Vérifier si des résultats ont été trouvés
        if ($results) {
            echo json_encode($results);
        } else {
            echo json_encode(['message' => 'Aucun avantage trouvé.']);
        }
    }

    // Fermer la connexion lorsque l'objet est détruit
    public function __destruct() {
        $this->conn = null; // On peut utiliser null pour fermer la connexion
    }
}

// Instancier le contrôleur
$controller = new AvantageController();

// Traitement des requêtes GET pour récupérer les avantages
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getAllAvantages();
} else {
    echo json_encode(['message' => 'Méthode non autorisée.']);
}
?>
