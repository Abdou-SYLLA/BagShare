<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BagShare - Worldwide Delivery</title>
    <link rel="stylesheet" href="styles/styles.css"> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Inclure jQuery -->
    <script src="Ajax.js"></script> <!-- Inclure ton fichier JS -->
</head>
<body>
    <!-- Inclusion du header -->
    <?php include '../src/views/header.php'; 
    
    // Activer l'affichage des erreurs
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>

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
        <div class="annonce-list" id="annonceList"> <!-- Ajoutez cet ID -->
            <!-- Les annonces seront ajoutées ici par JavaScript -->
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

