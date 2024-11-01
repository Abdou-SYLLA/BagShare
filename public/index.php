<?php
    session_start(); // Nécessaire pour accéder aux variables de session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BagShare - Rentabilisez vos bagages</title>
    <link rel="stylesheet" href="styles/styles.css"> <!-- Fichier CSS principal en Flexbox -->
    <link rel="stylesheet" href="styles/header.css"> 
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/mediaQueries.css"> <!-- Media queries pour le responsive -->

    <!-- Inclure jQuery pour AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="config.js" defer></script> <!-- JavaScript pour le chargement AJAX -->
</head>
<body>
    <!-- Inclusion du header -->
    <?php include '../src/views/header.php'; ?>

    <!-- Section principale / Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>Rentabilisez vos bagages, expédiez à prix réduit</h1>
            <p>Trouvez des voyageurs pour envoyer vos colis rapidement et en toute sécurité, à des tarifs compétitifs.</p>
            <a href="../src/views/annonce.php" class="btn-primary">Commencez à envoyer maintenant</a>
        </div>
        <img src="data/images/globe.png" alt="Illustration de BagShare : globe avec moyens de transport">
    </section>

    <!-- Section "Comment ça marche" avec Flexbox -->
    <section class="how-it-works">
        <h2>Comment ça marche ?</h2>
        <div class="steps">
            <div class="step">
                <img src="data/images/bagshare.jpeg" alt="Inscription">
                <h3>1. Trouver une annonce</h3>
                <p>Consultez les annonces des voyageurs prêts à partager leurs bagages.</p>
            </div>
            <div class="step">
                <img src="data/images/bagages1.jpeg" alt="Réservation de kilos">
                <h3>2. Réservez vos kilos</h3>
                <p>Sélectionnez la quantité de kilos disponible pour votre envoi et réservez en ligne.</p>
            </div>
            <div class="step">
                <img src="data/images/bagages.jpeg" alt="Livraison sécurisée">
                <h3>3. Expédiez en toute sécurité</h3>
                <p>Confiez vos colis à un voyageur et suivez l'envoi jusqu'à la livraison finale.</p>
            </div>
        </div>
    </section>

    <!-- Section avantages économiques et sécurité avec le viewer d'images et texte dynamique -->
    <section class="advantages">
        <h2>Pourquoi choisir BagShare ?</h2>
        
        <!-- Texte chargé dynamiquement depuis la base de données -->
        <nav id="advantages-text"></nav> <!-- Ce texte sera remplacé via AJAX -->
        
        <!-- Viewer d'images -->
        <div id="image-viewer" class="viewer">
            <button id="prev-btn" class="nav-btn">◀</button>
            <img id="current-image" src="" alt="Viewer image">
            <button id="next-btn" class="nav-btn">▶</button>
        </div>
<!-- Les images du viewer seront ajoutées ici en AJAX -->
    </section>

    <!-- Inclusion du footer -->
    <?php include '../src/views/footer.php'; ?>
</body>
</html>
