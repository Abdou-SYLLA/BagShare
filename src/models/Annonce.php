<?php
require_once '../../database/database.php'; 

class Annonce {
    private $conn;

    // Constructeur pour établir la connexion à la base de données
    public function __construct() {
        $dbConnection = new DatabaseConnection();
        $this->conn = $dbConnection->getConnection();
    }

    // Méthode pour récupérer toutes les annonces
    public function getAllAnnonces() {
        $sql = "SELECT description, depart, ville_depart, arrivee, ville_destination, date, kilos_disponibles, prix_par_kilo, adresse_depot, nom, R1.numero as numero, annonces.id as id, endroit_populaire 
                FROM annonces 
                INNER JOIN (SELECT nom, prenom, numero FROM accounts) as R1 ON R1.numero = annonces.numero 
                LEFT JOIN lieux ON LOWER(ville_destination) = LOWER(ville) 
                WHERE date >= CURDATE()";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAnnonce($data) {
        $stmt = $this->conn->prepare("INSERT INTO annonces (description, depart, ville_depart, arrivee, ville_destination, date, kilos_disponibles, prix_par_kilo, adresse_depot, numero) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        // Exécution de la requête et retour du résultat
        if ($stmt->execute([
            $data['description'], 
            $data['depart'],
            $data['ville_depart'], 
            $data['arrivee'],
            $data['ville_destination'], 
            $data['date'], 
            $data['kilos_disponibles'], 
            $data['prix_par_kilo'],
            $data['adresse_depot'], 
            $data['numero']
        ])) {
            return true; // Annonce créée avec succès
        } else {
            die("Erreur d'exécution de la requête : " . $stmt->errorInfo()[2]);
        }
    }

    // Méthode pour supprimer une annonce par son ID, si l'utilisateur est l'auteur ou un administrateur
    public function deleteAnnonce($annonceId, $userId, $isAdmin) {
        $stmt = $this->conn->prepare("SELECT numero FROM annonces WHERE id = ?");
        $stmt->execute([$annonceId]);
        $annonceOwnerId = $stmt->fetchColumn();

        // Si l'utilisateur est l'auteur de l'annonce ou un admin, on peut supprimer
        if ($annonceOwnerId === $userId || $isAdmin) {
            $deleteStmt = $this->conn->prepare("DELETE FROM annonces WHERE id = ?");
            $deleteStmt->execute([$annonceId]);
            return true; // Annonce supprimée avec succès
        } else {
            // L'utilisateur n'a pas les permissions nécessaires
            return false;
        }
    }

    // Fermer la connexion lorsque l'objet est détruit
    public function __destruct() {
        $this->conn = null; // Fermer la connexion
    }
}
?>
