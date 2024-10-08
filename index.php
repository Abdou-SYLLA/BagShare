<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BagShare - Worldwide Delivery</title>
    <link rel="stylesheet" href="styles/styles.css"> <!-- Chemin du fichier CSS -->
</head>
<body>
    <!-- Inclusion du header -->
    <?php include 'html/header.html'; ?>

    <section class="hero">
        <div class="hero-content">
            <h1>Livraison ultra rapide</h1>
            <p>Livraison en moins de 48h*</p>
            <a href="#" class="btn-primary">En savoir plus </a>
        </div>
        <img src="data/globe.png" alt="Globe">
    </section>

    <section class="annonces">
    <h2>Prochains départs</h2>
    <div class="annonce-list">
        <?php
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
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

    <section id="about-link" class="about-section" >
        <div class="container">
            <h1>À propos de BagShare</h1>
            <p>
                BagShare est une plateforme de mise en relation pour voyageurs souhaitant rentabiliser leurs kilos de bagages inutilisés en les proposant à d’autres utilisateurs à un prix compétitif. 
            </p>
            <p>
                Les utilisateurs peuvent acheter ces kilos pour envoyer leurs affaires entre pays et continents, en toute sécurité et à moindre coût. Par exemple, un voyageur en partance pour l'Italie peut mettre à disposition ses kilos excédentaires pour 10€/kilo.
            </p>
            <p>
                BagShare offre une alternative aux services de livraison classiques, plus flexible et économique.
            </p>

            <!-- Bouton pour revenir à la page d'accueil -->
            <a href="index.php" class="btn-secondary">Retour à l'accueil</a>
        </div>
        <img src="data\apropos.png" alt="apropos">
    </section>

    <!-- Inclusion du footer -->
    <?php include 'html/footer.html'; ?>
</body>
</html>

