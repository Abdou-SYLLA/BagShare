<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BagShare - Partage de bagages</title>
    <link rel="stylesheet" href="styles\styles.css">
</head>
<?php
    include_once('html\header.html');
?>
<body>
    <section>
        <h2>Annonces des voyageurs</h2>
        <div class="annonces">
            <?php
            
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
        
    <?php
    include_once('html/footer.html');
    ?>
</body>
</html>
