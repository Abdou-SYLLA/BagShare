<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Annonces</title>
    <link rel="stylesheet" href="/public/styles/styles.css"> 
    <link rel="stylesheet" href="/public/styles/mediaQueries.css"> 
    <link rel="stylesheet" href="/public/styles/annonces.css">
    <link rel="stylesheet" href="/public/styles/print.css" media="print">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../../public/scripts/annonces.js"></script>
    <script type="text/javascript">var isUserLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;</script>
</head>
<body>
<?php include 'header.php'; ?>

<section class="annonces">
    <h2 class="section-title">Prochains départs</h2> 
    <div class="annonce-list" id="annonceList">
        <!-- Les annonces seront ajoutées ici par JavaScript -->
    </div>
    <?php
    if (isset($_SESSION['user'])) {
        include_once ('AddAnnonce.php');
    }
    ?>
</section>



<?php include 'footer.php'; ?>
</body>
</html>
