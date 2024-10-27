<?php
    session_start(); // Nécessaire pour accéder aux variables de session
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BagShare - Worldwide Delivery</title>
    <link rel="stylesheet" href="/public/styles/styles.css"> 
    <link rel="stylesheet" href="/public/styles/footer.css">
    <link rel="stylesheet" href="/public/styles/header.css">
</head>

<?php include 'header.php'; ?>

<section class="about-section">
    <div class="container">
        <h1>À propos de BagShare</h1>
        <p>
            BagShare est une plateforme qui met en relation des voyageurs souhaitant rentabiliser les kilos de bagages inutilisés en les proposant à d'autres utilisateurs à des tarifs compétitifs, variables en fonction du poids et du type de produit.
        </p>
        <p>
            Les utilisateurs peuvent acquérir ces kilos pour expédier leurs affaires entre pays et continents, en toute sécurité et à des prix réduits. Par exemple, un voyageur se rendant en Italie peut proposer ses kilos excédentaires à un tarif qui dépendra du poids et de la nature des bagages.
        </p>
        <p>
            BagShare représente une alternative flexible et économique aux services de livraison traditionnels.
        </p>
    </div>
    <img src="/public/data/images/apropos.png" alt="apropos">
</section>

<?php include 'footer.php'; ?>
