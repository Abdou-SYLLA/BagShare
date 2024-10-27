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
    <link rel="stylesheet" href="styles/styles.css"> <!-- Inclusion du fichier CSS -->
    <link rel="stylesheet" href="styles/footer.css">
   
    <!-- Inclure jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Inclusion du header -->
    <?php 
    include '../src/views/header.php'; 
    ?>

    <!-- Section principale / Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>Rentabilisez vos bagages, expédiez à prix réduit</h1>
            <p>Trouvez des voyageurs pour envoyer vos colis rapidement et en toute sécurité, à des tarifs compétitifs.</p>
            <a href="../src/views/annonce.php" class="btn-primary">Commencez à envoyer maintenant</a>
        </div>
        <img src="data/images/globe.png" alt="Illustration de BagShare : globe avec moyens de transport">
    </section>

    <!-- Section "Comment ça marche" -->
    <section class="how-it-works">
        <h2>Comment ça marche ?</h2>
        <div class="steps">
            <div class="step">
                <img src="data/images/bagshare.jpeg" alt="Inscription">
                <h3>1. Trouver une annonce </h3>
                <p>Consulter les annonces des voyageurs prêts à partager leurs bagages.</p>
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

    <!-- Section avantages économiques et sécurité -->
    <section class="advantages">
        <h2>Pourquoi choisir BagShare ?</h2>
        <nav>
            <a>Des tarifs flexibles selon le poids et la destination</a>
            <a>Un réseau mondial de voyageurs prêts à partager leurs bagages</a>
            <a>Une solution rapide, sécurisée et écologique pour vos envois</a>
            <a>Un moyen rentable pour les voyageurs d'amortir leurs frais de voyage</a>
            <a>Contribue à la réduction de l'empreinte carbone en optimisant l'espace des bagages</a>
        </nav>
    </section>
    <!-- Inclusion du footer -->
    <?php include '../src/views/footer.php'; ?>
    
</body>
</html>
