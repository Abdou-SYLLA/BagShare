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
            <p>Livraison en moins de 48h </p>
            <a href="#" class="btn-primary">En savoir plus </a>
        </div>
    </section>

    <section class="annonces">
        <h2>Prochains departs </h2>
        <div class="annonce-list">
            <?php
            $annonces = [
                ['destination' => 'Italie', 'kilos_disponibles' => 10, 'prix_par_kilo' => 10,'date' =>  '2024-10-20'],
                ['destination' => 'France', 'kilos_disponibles' => 5, 'prix_par_kilo' => 8,'date' =>  '2024-11-20'],
                ['destination' => 'Espagne', 'kilos_disponibles' => 15, 'prix_par_kilo' => 12,'date' =>  '2024-12-20'],
                ['destination' => 'Espagne', 'kilos_disponibles' => 7, 'prix_par_kilo' => 10,'date' =>  '2024-20-20']
            ];

            foreach ($annonces as $annonce) {
                echo "<div class='annonce'>
                        <h3>Destination: {$annonce['destination']}</h3>
                        <p>Kilos disponibles: {$annonce['kilos_disponibles']} kg</p>
                        <p>Prix par kilo: {$annonce['prix_par_kilo']} €/kg</p>
                        <p>Date: {$annonce['date']} </p>
                      </div>";
            }
            ?>
        </div>
    </section>

    <!-- Inclusion du footer -->
    <?php include 'html/footer.html'; ?>
</body>
</html>

