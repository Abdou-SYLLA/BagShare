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
        FROM annonces INNER JOIN (SELECT nom, prenom, numero 
                                FROM accounts)as R1 ON R1.numero = annonces.numero LEFT JOIN lieux ON LOWER(ville_destination) = LOWER(ville) 
                                WHERE date >= CURDATE()";
        
        $result = $this->conn->query($sql);
    
        if (!$result) {
            return ["error" => "Erreur SQL : " . $this->conn->error];
        }
    
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
    
    
    

    public function createAnnonce($data) {
        // Requête préparée pour éviter les injections SQL
        $stmt = $this->conn->prepare("INSERT INTO annonces (description, depart, ville_depart, arrivee, ville_destination, date, kilos_disponibles, prix_par_kilo, adresse_depot, numero) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        // Vérification si la préparation a échoué
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }
    
        // Liaison des paramètres avec les types corrects
        $stmt->bind_param(
            "ssssssidsi", 
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
        );
    
        // Exécution de la requête et retour du résultat
        if ($stmt->execute()) {
            return true; // Annonce créée avec succès
        } else {
            die("Erreur d'exécution de la requête : " . $stmt->error);
        }
    }    
    
    
    

    // Méthode pour supprimer une annonce par son ID, si l'utilisateur est l'auteur ou un administrateur
    public function deleteAnnonce($annonceId, $userId, $isAdmin) {
        // Vérifier si l'utilisateur est bien l'auteur ou un admin
        $stmt = $this->conn->prepare("SELECT numero FROM annonces WHERE id = ?");
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
