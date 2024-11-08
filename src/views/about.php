<?php
    session_start(); // Nécessaire pour accéder aux variables de session
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BagShare - Worldwide Delivery</title>
    <link rel="stylesheet" href="/public/styles/styles.css"> 
    <link rel="stylesheet" href="/public/styles/mediaQueries.css"> 
    <link rel="stylesheet" href="/public/styles/print.css" media="print">
</head>

<?php include 'header.php'; ?>

<section class="about-section">
    <div class="container">
    <h1>À propos de BagShare</h1>
    <p>
        BagShare est une plateforme privée de mise en relation pour voyageurs souhaitant rentabiliser leurs kilos de bagages inutilisés en les proposant à d’autres utilisateurs à un prix compétitif. L’objectif est de permettre aux utilisateurs de partager ou d’acheter des kilos de bagages excédentaires pour envoyer leurs affaires entre pays et continents, en toute sécurité et à moindre coût.
    </p>
    <p>
        Les annonces sont récupérées depuis la base de données (BDD) et les utilisateurs peuvent proposer leurs kilos excédentaires ou en acheter. L’administrateur de la plateforme a un contrôle total sur la gestion des annonces et des comptes utilisateurs, tandis que les auteurs d’annonces peuvent supprimer celles qu’ils ont créées.
    </p>

    </div>
    <img src="/public/data/images/apropos3.png" alt="apropos">
</section>

<?php include 'footer.php'; ?>
