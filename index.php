<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MediConnect - Votre santé à porté de main</title>
    <link rel="stylesheet" href="styles\styles.css">
</head>

<?php include 'html\header.html'; ?>

<section>
    <h2>Annonces des voyageurs</h2>
    <div class="annonces">
        <?php
        // Exemple de données statiques - à remplacer par des données dynamiques plus tard
        $annonces = [
            ['destination' => 'Italie', 'kilos_disponibles' => 10, 'prix_par_kilo' => 10],
            ['destination' => 'France', 'kilos_disponibles' => 5, 'prix_par_kilo' => 8],
            ['destination' => 'Espagne', 'kilos_disponibles' => 15, 'prix_par_kilo' => 12]
        ];

        foreach ($annonces as $annonce) {
            echo "<div class='annonce'>
                    <h3>Destination: {$annonce['destination']}</h3>
                    <p>Kilos disponibles: {$annonce['kilos_disponibles']} kg</p>
                    <p>Prix par kilo: {$annonce['prix_par_kilo']} €/kg</p>
                  </div>";
        }
        ?>
    </div>
</section>

<?php include 'html\footer.html'; ?>
