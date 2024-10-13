<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BagShare - Worldwide Delivery</title>
    <link rel="stylesheet" href="styles/styles.css"> 
</head>
<body>
    <!-- Inclusion du header -->
    <?php include '../src/views/header.php'; ?>

    <section class="hero">
        <div class="hero-content">
            <h1>Livraison ultra rapide</h1>
            <p>Livraison en moins de 48h*</p>
            <a href="#" class="btn-primary">En savoir plus </a>
        </div>
        <img src="data/images/globe.png" alt="Globe">
    </section>

    <section class="annonces">
    <h2>Prochains départs</h2>
    <div class="annonce-list">
        <?php
        // Connexion à la base de données
        $servername = "127.0.0.1";
        $username = "root";
        $password = "12345678";
        $dbname = "bagshare";

        // Créer une connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("Connexion échouée: " . $conn->connect_error);
        }

        // Requête pour récupérer les annonces
        $sql = "SELECT description, depart, arrivee, date, kilos_disponibles, prix_par_kilo, nom FROM annonces NATURAL JOIN users WHERE date >= CURDATE()";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Afficher chaque annonce
            while($row = $result->fetch_assoc()) {
                echo "<div class='annonce'>
                        <h3>Destination: " . $row["arrivee"] . "</h3>
                        <p>Départ: " . $row["depart"] . "</p>
                        <p>Kilos disponibles: " . $row["kilos_disponibles"] . " kg</p>
                        <p>Prix par kilo: " . $row["prix_par_kilo"] . " €/kg</p>
                        <p>Date: " . $row["date"] . "</p>
                        <p>Voyageur: " . $row["nom"] . "</p>
                      </div>";
            }
        } else {
            echo "Aucune annonce trouvée.";
        }

        // Fermer la connexion
        $conn->close();
        ?>
    </div>
</section>

    <!-- ajout d'annonce avec php pour mode connecté -->
    <?php 
    
    if (isset($_SESSION['user'])) {
        # code...
    }
    
    ?>
    
    <!-- Inclusion du footer -->
    <?php include '../src/views/footer.php'; ?>
</body>
</html>

