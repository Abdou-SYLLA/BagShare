<?php
class Annonce {
    private $conn;

    // Constructeur pour établir la connexion à la base de données
    public function __construct() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "12345678";
        $dbname = "bagshare";

        // Créer une connexion
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier la connexion
        if ($this->conn->connect_error) {
            die("Connexion échouée: " . $this->conn->connect_error);
        }
    }

    // Méthode pour récupérer toutes les annonces
    public function getAllAnnonces() {
        $sql = "SELECT description, depart, arrivee, date, kilos_disponibles, prix_par_kilo, nom 
                FROM annonces 
                NATURAL JOIN users 
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

    // Fermer la connexion lorsque l'objet est détruit
    public function __destruct() {
        $this->conn->close();
    }
}
?>
