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
        $sql = "SELECT description, depart,ville_depart, arrivee,ville_destination, date, kilos_disponibles, prix_par_kilo, adresse_depot, nom 
                FROM annonces 
                INNER JOIN accounts ON accounts.numero = annonces.numero
                WHERE date >= CURDATE()";
        
        $result = $this->conn->query($sql);
    
        // Vérification des erreurs SQL
        if (!$result) {
            die("Erreur SQL : " . $this->conn->error);
        }
    
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC); // Retourner un tableau associatif
        } else {
            return []; // Aucun résultat
        }
    }

    // Méthode pour ajouter une annonce
    public function createAnnonce($data) {
        // Requête préparée pour éviter les injections SQL
        $stmt = $this->conn->prepare("INSERT INTO annonces (description, depart,ville_depart, arrivee,ville_destination,  date, kilos_disponibles, prix_par_kilo, adresse_depot, nom ) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssddi", $data['description'], $data['depart'],$data['ville_depart'], $data['arrivee'],$data['ville_destination'], $data['date'], $data['kilos_disponibles'], $data['prix_par_kilo'],$data['adresse_depot'] ,$data['nom']);
        
        if ($stmt->execute()) {
            return true; // Annonce créée avec succès
        } else {
            return false; // Erreur lors de la création
        }
    }

    // Méthode pour supprimer une annonce par son ID, si l'utilisateur est l'auteur ou un administrateur
    public function deleteAnnonce($annonceId, $userId, $isAdmin) {
        // Vérifier si l'utilisateur est bien l'auteur ou un admin
        $stmt = $this->conn->prepare("SELECT user_id FROM annonces WHERE id = ?");
        $stmt->bind_param("i", $annonceId);
        $stmt->execute();
        $stmt->bind_result($annonceOwnerId);
        $stmt->fetch();
        $stmt->close();

        // Si l'utilisateur est l'auteur de l'annonce ou un admin, on peut supprimer
        if ($annonceOwnerId === $userId || $isAdmin) {
            $deleteStmt = $this->conn->prepare("DELETE FROM annonces WHERE id = ?");
            $deleteStmt->bind_param("i", $annonceId);
            
            if ($deleteStmt->execute()) {
                return true; // Annonce supprimée avec succès
            } else {
                return false; // Erreur lors de la suppression
            }
        } else {
            // L'utilisateur n'a pas les permissions nécessaires
            return false;
        }
    }

    // Fermer la connexion lorsque l'objet est détruit
    public function __destruct() {
        $this->conn->close();
    }
}
?>
